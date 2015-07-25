<?php
/**
 * This configuration should be put in your module `configs` directory.
 */
return array(
    'assetic_configuration' => array(
        // Use on production environment
        // 'debug'              => false,
        // 'buildOnRequest'     => false,

        // Use on development environment
        'debug' => true,
        'buildOnRequest' => true,

        // This is optional flag, by default set to `true`.
        // In debug mode allow you to combine all assets to one file.
        // 'combine' => false,

        // this is specific to this project
        'webPath' => realpath('public/assets'),
        'basePath' => 'public/assets',

        'routes' => array(
             'adminHome' => array(
                '@base_js',
                '@base_css',
            ),
        ),

        'modules' => array(
            'Admin' => array(
                'root_path' => __DIR__ . '/../assets',

                'collections' => array(
                    'admin_css' => array(
                        'assets' => array(
                            'css/admin.css',
                            // 'css/main2.css',
                        ),
                        'filters' => array(
                            '?CssRewriteFilter' => array(
                                'name' => 'Assetic\Filter\CssRewriteFilter'
                            ),
                            '?CssMinFilter' => array(
                                'name' => 'Assetic\Filter\CssMinFilter'
                            ),
                        ),
                    ),
                    'admin_js' => array(
                        'assets' => array(
                        // 'js/main1.js',
                            // 'js/main2.js',
                        ),
                        'filters' => array(
                            '?JSMinFilter' => array(
                                'name' => 'Assetic\Filter\JSMinFilter'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
