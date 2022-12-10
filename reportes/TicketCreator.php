<?php
class TicketCreator extends PrintReporte
{
    public function headHtml()
    {
        return "<head>
        <meta http-equiv='content-type' content='text/html; charset=utf-8' />
        <link href='../public/css/ticket.css' rel='stylesheet' type='text/css'>
        </head>
        <body onload='window.print();'>
        <div class='zona_impresion'>";
    }

    
    public function crearReporte($id): TicketProduct
    {
        return new TicketProduct($id, $this->data, $this->headHtml());
    }
   
}
