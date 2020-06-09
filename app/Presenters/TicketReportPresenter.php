<?php

namespace App\Presenters;
use Auth;
/**
 * Class TicketPresenter
 * @package App\Presenters
 */
class TicketReportPresenter extends Presenter
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
                "field" => "assigned_to",
                "searchable" => false,
                "sortable" => true,
                "title" => "Assigned Agent",
                "visible" => true,
            ],[
                "field" => "status",
                "searchable" => false,
                "sortable" => true,
                "title" => "Status",
                "visible" => true,
            ],[
                "field" => "created_at.datetime",
                "searchable" => false,
                "sortable" => true,
                "title" => "Created At",
                "visible" => true,
            ],[
                "field" => "hours",
                "searchable" => false,
                "sortable" => true,
                "title" => "No Of Hours",
                "visible" => true,
            ]];

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
