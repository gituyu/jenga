<?php


namespace Finserve\Jenga;


class Callback
{
    public static function processAccountAlerts()
    {
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);
        $mobileNumber = $callbackData->mobileNumber;  //254XXXXXXX
        $message = $callbackData->message; //reciever mobile number is unregistered in M-Pesa
        $rrn = $callbackData->rrn;
        $service = $callbackData->service; //Mpesa
        $tranID = $callbackData->tranID;
        $resultCode = $callbackData->resultCode;
        $resultDescription = $callbackData->resultDescription;
        $additionalInfo = $callbackData->additionalInfo;

        $result = [
            "mobileNumber" => $mobileNumber,
            "message" => $message,
            "rrn" => $rrn,
            "service" => $service,
            "tranID" => $tranID,
            "resultCode" => $resultCode,
            "resultDescription" => $resultDescription,
            "additionalInfo" => $additionalInfo,
        ];
        return json_encode($result);
    }

    public static function process()
    {
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);

        $customername = $callbackData->customer->name; //reciever mobile number is unregistered in M-Pesa
        $customermobileNumber = $callbackData->customer->mobileNumber; //254XXXXXXX
        $customerRef = $callbackData->customer->reference;

        $txDate = $callbackData->transaction->date;
        $txRef = $callbackData->transaction->reference;
        $txPaymentMode = $callbackData->transaction->paymentMode;
        $txAmount = $callbackData->transaction->amount;
        $txTill = $callbackData->transaction->till;
        $txBillNumber = $callbackData->transaction->billNumber;
        $txOrderAmount = $callbackData->transaction->orderAmount;
        $txServiceCharge = $callbackData->transaction->serviceCharge;
        $txServedBy = $callbackData->transaction->servedBy;
        $txAdditionalInfo = $callbackData->transaction->additionalInfo;

        $bnkRef = $callbackData->bank->reference;
        $bnkTransactionType = $callbackData->bank->transactionType;
        $bnkAccount = $callbackData->bank->account;

        $result = [
            "customernumber" => $customername,
            "customermobileNumber" => $customermobileNumber,
            "customerRef" => $customerRef,
            "txDate" => $txDate,
            "txRef" => $txRef,
            "txPaymentMode" => $txPaymentMode,
            "txAmount" => $txAmount,
            "txTill" => $txTill,
            "txBillNumber" => $txBillNumber,
            "txOrderAmount" => $txOrderAmount,
            "txServiceCharge" => $txServiceCharge,
            "txServedBy" => $txServedBy,
            "txAdditionalInfo" => $txAdditionalInfo,
            "bnkRef" => $bnkRef,
            "bnkTransactionType" => $bnkTransactionType,
            "bnkAccount" => $bnkAccount
        ];

        return json_encode($result);
    }
}