<?php
namespace App\Http\Transformers;


use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;
use Auth;
use Log;

class TicketsReportTransformer
{
    
    public function transformTicketsReport (Collection $ticketys,$total)
    {   
       
        $array = array();
        $i = 1;
        foreach ($ticketys as $ticket) {
            $no = $i++;
            $array[] = self::transformTicketReport($ticket,$no);
            
            
        }
        
        
        return (new DatatablesTransformer)->transformDatatables($array);
    }
    
    public function transformTicketReport (Ticket $ticket = null,$no)
    {
        
        
        if ($ticket) {
            
            $array = [
                'id' => (int) $ticket->id,
                
                'ticket_id' => e($ticket->ticket_id),
                'first_name' => ($ticket->user_id) ? ['id' => (int) $ticket->user->id,'name'=> e($ticket->user->first_name)] : null,
                'created_for' => ($ticket->first_name),
                'title' =>   ($ticket->name),
                'priority_type' => ($ticket->priority_type),
                'status' => ($ticket->status),
                'category_type' => ($ticket->category_type),
                'department' => ($ticket->department) ? ['id' => (int) $ticket->departments->id,'name'=> e($ticket->departments->name).'-'.e($ticket->departments->building).'-'.e($ticket->departments->floor)] : null,
                'wing' => ($ticket->wing_id) ? ['id' => (int) $ticket->wing->id,'name'=> e($ticket->wing->wing)] : null,
                'room' => ($ticket->room_id) ? ['id' => (int) $ticket->room->id,'name'=> e($ticket->room->room_name)] : null,
                'extension' => ($ticket->extension),
                'company_id' => ($ticket->company_id) ? ['id' => (int) $ticket->company->id,'name'=> e($ticket->company->name)] : null,
                'ticketId' => ($ticket->ticketId) ,
                'assigned_to' => (isset($ticket['assign'])) ? $ticket->getAssignedName($ticket['assign']->assigned_to): null,
                'created_at' => Helper::getFormattedDateObject($ticket->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($ticket->updated_at, 'datetime'),
                'hours' => ($ticket->getHours($ticket->id))
                
            ];
            
            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Ticket::class) ? true : false,
                'delete' => Gate::allows('delete', Ticket::class) ? true : false,
                
            ];
            
            $array += $permissions_array;
            return $array;
        }
        
        
        
        
    }
    
    public function transformTicketsDatatable($ticket) {
        return (new DatatablesTransformer)->transformDatatables($ticket);
    }
    
    
    
    
}
