<?php

namespace App\Presenters;
use Auth;
/**
 * Class TicketPresenter
 * @package App\Presenters
 */
class TicketPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "title" => "Ticket Id",
                "visible" => true,
            ],[
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => false
            ],
            [
                "field" => "first_name.name",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => "Ticket Created By",
                "visible" => true,
            ],[
                "field" => "created_for",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => "Ticket Created For",
                "visible" => true,
            ],[
                "field" => "title",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => "Title",
                "visible" => true,


            ],[
                "field" => "ticket_id",
                "searchable" => false,
                "sortable" => true,
                "title" => "Ticket No",
                "visible" => true,
            ],[
                "field" => "company_id.name",
                "searchable" => false,
                "sortable" => true,
                "title" => "Company",
                "visible" => true,
            ],[
                "field" => "category_type",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => "Category Type",
                "visible" => true,

            ],[
                "field" => "priority_type",
                "searchable" => false,
                "sortable" => true,
                "title" => "Priority",
                "visible" => true,

            ],[
                "field" => "department.name",
                "searchable" => false,
                "sortable" => true,
                "title" => "Department",
                "visible" => true,
            ],[
                "field" => "wing.name",
                "searchable" => false,
                "sortable" => true,
                "title" => "Wing",
                "visible" => true,
            ],[
                "field" => "room.name",
                "searchable" => false,
                "sortable" => true,
                "title" => "Room",
                "visible" => true,
            ]
            ,[
                "field" => "extension",
                "searchable" => false,
                "sortable" => true,
                "title" => "Extension",
                "visible" => true,
            ],[
                "field" => "status",
                "searchable" => false,
                "sortable" => true,
                "title" => "Status",
                "visible" => true,
                "formatter" => "ticketsstatusValue",

            ]];
        if(Auth::user()->isSuperUser()){
            $layout[] = [
                "field" => "status",
                "searchable" => false,
                "sortable" => false,
                "switchable" => true,
                "title" => "Assign",
                "visible" => true,
                "formatter" => "ticketsAssignActionFormatter",
            ];

        }

        if(Auth::user()->isSuperUser()){
            $layout[] =  [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => true,
                "title" => "Logs",
                "visible" => true,
                "formatter" => "ticketsLogsActionFormatter",
            ];
        }
        if(Auth::user()->isSuperUser()){
        $layout[] = [
            "field" => "actions",
            "searchable" => false,
            "sortable" => false,
            "switchable" => false,
            "title" => trans('table.actions'),
            "formatter" => "ticketsActionsFormatter",
        ];
        }

        if(Auth::user()->isDepartment() == true){
            $layout[] = [
                "field" => "status","id",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "formatter" => "genericAgentActionFormatterexample",
            ];
        }

        if(Auth::user()->isTicketClosed() == true){
            $layout[] = [
                "field" => "status","id",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => "Acknowledge",
                "formatter" => "AckActionFormatterexample",
            ];
        }

        return json_encode($layout);
    }


    /**
     * Link to this companies name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('tickets.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('tickets.show', $this->id);
    }
}
