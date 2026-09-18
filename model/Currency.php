<?php

class Currency
{
    private $rates;


    public function __construct()
    {
        $this->rates = [

            "BDT" => [
                "BDT" => 1,
                "USD" => 0.0082,
                "EUR" => 0.0075
            ],

            "USD" => [
                "BDT" => 122,
                "USD" => 1,
                "EUR" => 0.91
            ],

            "EUR" => [
                "BDT" => 133,
                "USD" => 1.10,
                "EUR" => 1
            ]

        ];
    }


    /* =========================
       CONVERT CURRENCY
    ========================= */

    public function convert(
        $amount,
        $from,
        $to
    ) {

        $amount = floatval($amount);

        $from = strtoupper(
            trim($from)
        );

        $to = strtoupper(
            trim($to)
        );


        if (
            $amount > 0 &&
            isset($this->rates[$from]) &&
            isset($this->rates[$from][$to])
        ) {

            $convertedAmount =
                $amount *
                $this->rates[$from][$to];


            return [

                "success" => true,

                "amount" => $amount,

                "from" => $from,

                "result" =>
                    round(
                        $convertedAmount,
                        2
                    ),

                "to" => $to

            ];
        }


        return [

            "success" => false

        ];
    }
}

?>