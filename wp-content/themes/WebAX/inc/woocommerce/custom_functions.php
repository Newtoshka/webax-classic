<?php

/** Registration policy privacy */
function add_registration_privacy_policy() {
    woocommerce_form_field( 'privacy-policy-reg', array(
        'type'          => 'checkbox',
        'class'         => array('form-row privacy'),
        'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'label'         => '<span>Twoje dane osobowe zostaną użyte do obsługi twojej wizyty na naszej stronie, zarządzania dostępem do twojego konta i dla innych celów o których mówi nasza <a class="privacy_policy_link" href="/polityka-prywatnosci" target="_blank">POLITYKA PRYWATNOŚCI</a>.</span>',
        'required'      => true
    ), 1);
}

add_action( 'woocommerce_register_form', 'add_registration_privacy_policy', 11 );

function validate_registration_privacy_policy( $username, $email, $validation_errors ) {
    if ( !isset( $_POST['privacy-policy-reg'] ) || empty( $_POST['privacy-policy-reg'] ) ) {
           $validation_errors->add( 'privacy_policy_reg_error', __( 'Zgoda na wykorzystanie danych osobowych jest obowiązkowa do utworzenia konta.', 'woocommerce' ) );
    }
    return $validation_errors;
}

add_action('woocommerce_register_post', 'validate_registration_privacy_policy', 10, 3);

// Remove Downloads My Account
function custom_my_account_menu_items( $items ) {
    unset($items['downloads']);
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );