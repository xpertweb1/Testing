<?php

/*
 * This is the EDD license manager for WP Full Stripe
 */


if ( ! class_exists( 'MM_WPFS_EDD_License' ) ) {
    include(WP_FULL_STRIPE_DIR . 'includes/wp-full-stripe-edd-license.php');
}

if ( ! class_exists( 'WPFS_EDD_SL_Plugin_Updater' ) ) {
    include(WP_FULL_STRIPE_DIR . 'includes/edd/WPFS_EDD_SL_Plugin_Updater.php');
}


class MM_WPFS_LicenseManager extends MM_WPFS_LicenseManager_Root {
    const WPFS_AUTHOR_MAMMOTHOLOGY = 'Mammothology';

    const OPTION_KEY_EDD_LICENSE_KEY = 'edd_license_key';
    const OPTION_KEY_EDD_LICENSE_STATUS = 'edd_license_status';

    const OPTION_VALUE_EDD_LICENSE_STATUS_UNKNOWN = 'unknown';
    const OPTION_VALUE_EDD_LICENSE_STATUS_INACTIVE = 'inactive';

    public static $instance;

    private function __construct() {
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new MM_WPFS_LicenseManager();
        }

        return self::$instance;
    }

    private function getLicenseKey() {
        $options     = get_option( 'fullstripe_options' );
        $license_key = trim( $options[self::OPTION_KEY_EDD_LICENSE_KEY] );

        return $license_key;
    }

    public function initPluginUpdater() {
        new WPFS_EDD_SL_Plugin_Updater( WPFS_EDD_SL_STORE_URL, __FILE__, array(
            'version'   => MM_WPFS::VERSION,
            'license'   => $this->getLicenseKey(),
            'item_name' => WPFS_EDD_SL_ITEM_NAME,
            'author'    => self::WPFS_AUTHOR_MAMMOTHOLOGY,
            'url'       => home_url()
        ) );
    }

    public function getLicenseOptionDefaults() {
        return array(
            self::OPTION_KEY_EDD_LICENSE_KEY       => MM_WPFS_LicenseConfig_EDD::KEY,
            self::OPTION_KEY_EDD_LICENSE_STATUS    => self::OPTION_VALUE_EDD_LICENSE_STATUS_UNKNOWN
        );
    }

    public function setLicenseOptionDefaultsIfEmpty(& $options) {
        if ( ! array_key_exists( self::OPTION_KEY_EDD_LICENSE_KEY, $options ) ) {
            $options[self::OPTION_KEY_EDD_LICENSE_KEY] = MM_WPFS_LicenseConfig_EDD::KEY;
        }
        if ( ! array_key_exists( self::OPTION_KEY_EDD_LICENSE_STATUS, $options ) ) {
            $options[self::OPTION_KEY_EDD_LICENSE_STATUS] = self::OPTION_VALUE_EDD_LICENSE_STATUS_UNKNOWN;
        }
    }

    public function activateLicenseIfNeeded() {
        // tnagy reload saved options and check edd license status
        $options       = get_option( 'fullstripe_options' );
        $licenseStatus = $options['edd_license_status'];
        if ( $licenseStatus == self::OPTION_VALUE_EDD_LICENSE_STATUS_UNKNOWN ||
            $licenseStatus == self::OPTION_VALUE_EDD_LICENSE_STATUS_INACTIVE ) {
            $this->activateLicense();
        }
    }

    private function activateLicense() {
        $options = get_option( 'fullstripe_options' );
        $license = $options[self::OPTION_KEY_EDD_LICENSE_KEY];

        $apiParameters = array(
            'edd_action' => 'activate_license',
            'license'    => $license,
            'item_name'  => urlencode( WPFS_EDD_SL_ITEM_NAME ),
            'url'        => home_url()
        );

        $response = wp_remote_post( WPFS_EDD_SL_STORE_URL, array(
            'timeout'   => 1,
            'sslverify' => false,
            'body'      => $apiParameters
        ) );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $licenseData = json_decode( wp_remote_retrieve_body( $response ) );

        $options[self::OPTION_KEY_EDD_LICENSE_STATUS] = $licenseData->license;
        update_option( 'fullstripe_options', $options );

        return true;
    }
}

MM_WPFS_LicenseManager::getInstance();