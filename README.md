# Paypost

> The module for accepting payments by Kazpost

- installation
- example
- license


## Installation

- ```composer require dosarkz/paypost```
- ```php artisan vendor:publish --provider="Dosarkz\PayPost\ServiceProviders\PayPostServiceProvider"```
- that's it. 

---

## Example

```
  $payPost = PayPost::generateUrl([
                'amount' => "sum of purchase",
                'email' => "customeremail",
                'language' => 'ru',
                'currency' => 'KZT',
                'type' => 'card',
                'payment_webhook' => "here your url webhook use only working url (real)"
  ]);

  if ($payPost->success) {
      // todo white success instructions
      
      $paymentId = $payPost->result->payment;
      $paymentUrl = $payPost->result->url;
  }
```

---

## License

[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2018 ©
