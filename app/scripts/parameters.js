angular.module('angularStripeTestApp')

    .constant('STRIPE_KEY', 'pk_test_xf2bcw46zdJHzYC8sgwRfASh')

    .constant('LOGIN_URL', 'http://app.angular-symfony-stripe.local/app_dev.php/security/login')
    .constant('LOGOUT_URL', 'http://app.angular-symfony-stripe.local/app_dev.php/security/logout')
    .constant('PAYMENT_URL', 'http://app.angular-symfony-stripe.local/app_dev.php/payment/pays')
    .constant('USER_ME_URL', 'http://app.angular-symfony-stripe.local/app_dev.php/user/me');