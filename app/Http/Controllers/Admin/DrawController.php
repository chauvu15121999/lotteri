<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Phase;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Winner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DrawController extends Controller
{
    public function manual()
    {
        $pageTitle = "Manual Draw";
        $manuals = Phase::waitingForManualDraw()->get();
        $phase = '';
        return view('admin.draw.manual', compact('pageTitle', 'manuals', 'phase'));
    }


    public function findTicket($id)
    {
        $manuals = Phase::waitingForManualDraw()->get();

        $phase     = (clone $manuals)->where('id', $id)->first();
        $tickets   = Ticket::where('phase_id', $id)->with('user')->get()->toArray();
        $ticketsGroupByNumber = array();
        foreach ( $tickets as $key => $ticket) {
            if (!array_key_exists($ticket['ticket_number'], $ticketsGroupByNumber)) {
                $ticketsGroupByNumber[$ticket['ticket_number']] = $ticket;
                $ticketsGroupByNumber[$ticket['ticket_number']]['users'][] = $ticket['user'];
                $ticketsGroupByNumber[$ticket['ticket_number']]['amount_person'][] = $ticket['user']['id'];
            } else {
                array_push($ticketsGroupByNumber[$ticket['ticket_number']]['users'],$ticket['user']);
                if (!in_array($ticket['user']['id'],$ticketsGroupByNumber[$ticket['ticket_number']]['amount_person'])) {
                    array_push($ticketsGroupByNumber[$ticket['ticket_number']]['amount_person'],$ticket['user']['id']);
                }
            }
        }
        $tickets = collect($tickets);
        $ticketsGroupByNumber = collect($ticketsGroupByNumber);
        $pageTitle = "Manual Draw of " . @$phase->lottery->name;
        return view('admin.draw.manual', compact('pageTitle', 'manuals', 'phase', 'tickets','ticketsGroupByNumber'));
    }

    public function draw(Request $request, $id)
    {
        $request->validate([
            'number'   => 'nullable|array',
            'number.*' => 'required|integer'
        ]);

        $phase = Phase::where('status', Status::ENABLE)->where('draw_status', Status::RUNNING)->where('draw_type', Status::MANUAL)->where('draw_date', '<=', Carbon::now())->findOrFail($id);

        $general = gs();
        $winTicketNumber = $request->number;
        $winBonuses      = $phase->lottery->bonuses;

        if (collect($winTicketNumber)->count() > $winBonuses->count() || collect($winTicketNumber)->count() != $winBonuses->count()) {
            $notify[] = ['error', 'You have to select ' . $winBonuses->count() . ' number tickets'];
            return back()->withNotify($notify);
        }
        foreach ($winTicketNumber as $key => $number) {
            $tickets = Ticket::where('ticket_number', $number)->where('phase_id',$id)->get();
            
            $bonus  = @$winBonuses->where('level', $key)->first();
            if (!$bonus) {
                break;
            }
            $getBonus = round(@$bonus->amount / count($tickets));
            foreach ($tickets as $key => $ticket) {
                $user   = $ticket->user;

                $winner = new Winner();
                $winner->ticket_id     = $ticket->id;
                $winner->user_id       = $user->id;
                $winner->phase_id      = $phase->id;
                $winner->ticket_number = $number;
                $winner->level         = $bonus->level;
                $winner->win_bonus     = $getBonus;
                $winner->save();

                $user->balance += $getBonus;
                $user->save();

                $transaction = new Transaction();
                $transaction->amount       = $getBonus;
                $transaction->user_id      = $user->id;
                $transaction->charge       = 0;
                $transaction->trx          = getTrx();
                $transaction->trx_type     = '+';
                $transaction->details      = 'You are winner ' . ordinal($bonus->level) . ' of ' . @$ticket->lottery->name . ' of phase ' . @$ticket->phase->phase_number;
                $transaction->remark       = 'win_bonus';
                $transaction->post_balance = $user->balance;
                $transaction->save();

                $phase->draw_status = Status::COMPLETE;
                $phase->save();

                $ticket->status = Status::PUBLISHED;
                $ticket->save();

                if ($general->win_commission = Status::ENABLE) {
                    levelCommission($user->id, $getBonus, 'win_commission');
                }
                notify($user, 'WIN_EMAIL', [
                    'lottery'  => $ticket->lottery->name,
                    'number'   => $number,
                    'amount'   => $getBonus,
                    'level'    => $bonus->level,
                    'currency' => $general->cur_text
                ]);
            }
        }
        $notify[] = ['success', 'Winner has been create successfully'];
        return to_route('admin.lottery.draw.manual')->withNotify($notify);
    }
}
