Chargify 
========

Follow these directions to set up recurring commissions from Chargify for your Referral (or Affiliate) program.

NOTE: **You must also have the ambassador javascript snippet on your payment success page, to record the initial commission.**

1) Go to Chargify -> Settings -> Webhooks

* Enable webhooks
* Specify URL to your webhook handler
* Check "Renewal Success" in "Webhooks subscriptions"
* Save webhooks settings

![](images/chargify_webhook_renewal.png?raw=true)

2) Add ambassador_chargify.php file to your libraries folder.

3) Set values for $username, $api_key and $campaign_uid variables, and add additional variables (optional).

You can find them here:

* https://getambassador.com/c/general
* https://getambassador.com/c/campaigns

Additional Variable Information located in API docs:

* https://getAmbassador.com/api


4) In your function which handles webhook data add this code:

4.1 PHP

NOTE: You need to specify path to your library folder

```php
require_once(PATH_TO_LIBRARY_FOLDER.'/ambassador_chargify.php');
$ambassador_chargify = new Ambassador_chargify();
$ambassador_chargify->renewal();
```

4.2 PHP + CodeIgniter

```php
$this->load->library('ambassador_chargify');
$this->ambassador_chargify->renewal();
```

5) Run your webhook URL in a browser to check if there are any errors displayed
