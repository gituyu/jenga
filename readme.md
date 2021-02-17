**Configuration**<br>
At your project root, create a .env file set these configs:

`JENGA_USERNAME=[username]` <br>
`JENGA_PASSWORD=[password]` <br>
`JENGA_API_KEY=[api_key]` <br>
`JENGA_PRIVATE_KEY=[/relative/path/to/private.pem]` <br>
`JENGA_BASE_ENDPOINT=https://uat.jengahq.io`<br>

For Laravel users, open the Config/App.php file and add `\Finserve\Jenga\JengaServiceProvider::class` under providers
and ` 'Jenga'=> \Finserve\Jenga\JengaServiceProvider::class` under aliases.

**Callback**<br>

```json
{
  "customernumber": "A N Other",
  "customermobileNumber": "",
  "customerRef": null,
  "txDate": "2018-11-27 00:00:00.0",
  "txRef": " S2596405",
  "txPaymentMode": "TPG",
  "txAmount": "10",
  "txTill": null,
  "txBillNumber": "A N Other",
  "txOrderAmount": "",
  "txServiceCharge": "",
  "txServedBy": "EQ",
  "txAdditionalInfo": "MPS 254723000000 MKR35QEKV7 A N Other/537620",
  "bnkRef": " S2596405",
  "bnkTransactionType": "C",
  "bnkAccount": "0111234241028"
}
```