lib_options
===========

A controller and a layout which allow you to easily make a configuration form for any application.

Licensed under [MIT License](http://opensource.org/licenses/MIT)

Current version: 0.4

**Get started**

* Install the application
* That's all !

You can use this app in two different way without modifying it.
**First way : use it to configure any application**

***1/ Extend the lib_options controller***

In any app, add a controller which extends \Lib\Options\Controller_Admin_Options
You don't need it to have any methods at all.

Exemple : 

    namespace Bru\Google\Analytics;
    
    class Controller_Admin_Options extends \Lib\Options\Controller_Admin_Options
    {
    }


***2/ Use the lib_options layout***

After that, right the config file wich is directly connected with your controller. In our exemple, the config file goes in :
config/controller/admin/options.config.php

The lib_options app add a new layout to Novius OS.
This layout is based on the typographic grid already used in NOS.
Next, an empty configuration that you can take to do yours :

    return array(
        'form_name' => 'My configuration form', //Optional
        'layout' => array(
            'lines' => array(
                array(
                    'cols' => array(
                        array(
                            'col_number' => 5,
                            'view' => 'nos::form/expander',
                            'params' => array(
                                'title'   => __('Expander name'),
                                'options' => array(
                                    'allowExpand' => false,
                                ),
                                'content' => array(
                                    'view' => 'nos::form/fields',
                                    'params' => array(
                                        'fields' => array(
                                            'your_first_field',
                                            'your_second_field',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'fields' => array(
            'your_first_field' => array(
                'label' => __('First field'),
                'form' => array(
                ),
            ),
            'your_second_field' => array(
                'label' => __('second field'),
                'form' => array(
                ),
            ),
        ),
    );

The layout is based on 'lines' which contain 'cols'. You can add key to the differents lines and cols if you like.
Lines are defined by any cols that you want.
Cols are defined by the 'col_number' key that say how large your column is. The 'view' key is also needed. 
In our exemple, we use the expander view which is in the NOS core, but you can use any view that you want.

***3/ Add an entry point to see your brand new form***

All you need now is a entry point to your form. So add it, with a launcher in your app or an action in the main bar of any appdesk.
Choice is yours.
An exemple of launcher that calls our previous controller :

    'bru_google_analytics_launcher_configuration' => array(
        'name' => 'Google Analytics Tag Configuration',
        'icon64' => 'static/apps/bru_google_analytics/images/google_analytics-64.png',
        'action' => array(
            'action' => 'nosTabs',
            'tab' => array(
                'url' => 'admin/bru_google_analytics/options',
            )
        ),
    ),

Above, the index action of your controller is called (default action of fuel). In the lib_options, the index action call the form action of the controller.
So you will have the same result if you call "admin/bru_google_analytics/options/form" in the previus example.
This method do the job in the lib options controller, so if you don't call it, nothing append!


***4/ Enjoy!***

Now, you can see your new options form. You can put all what you want in it. All is written in a small config file.
And when you want use all those datas, you can :
* Manually load the config file
* Call the static method Controller_MyOptionsController::getOptions() that load the config file for you and return datas as an array.

**Second way : just add a configuration to the lib options controller**
You want to use the lib_options power without add an application for that ? Simple !
You have just to add the same type of configuration that you can see above but in the lib_options controller himself.
To do that, listen the config load event for the controller :
    
    Event::register_function('config|lib_options::controller/admin/options', function(&$config)
    {
        $your_config = array(
    	    //...
        );
        $config = \Arr::merge($config, $your_config);
    }

You'll still have to create an entry point : if the use of a launcher suits you, the local/config/metadata.config.php file could do the job.
Enjoy ! (again)

I hope there is no mistake in the code that I give you.
Do not hesitate to tell me if there is! And do not hesitate to correct my english to !

***5/ Go further***

The lib_options app allow even much than that !

***Common fields***

In your fields configurations, you can add a key `common_field` to true. With that, the field value will be shared in all available context. Thoses datas are tock in the first level of the array retrive by the `getOptions` method.


***More actions***

Into your controller configuration file you can add a `toolbar_actions` key. There is an exemple that add 2 actions button to you option form.

    'toolbar_actions' => array(
        'import' => array(
            'action' => array(
                'action' => 'nosDialog',
                'dialog' => array(
                    'ajax' => true,
                    'contentUrl' => 'admin/my_app/my_controller/import',
                    'title' => 'Import datas',
                ),
            ),
            'label' => 'Import datas',
            'icon' => 'arrowstop-1-s',
        ),
        'export' => array(
            'action' => array(
                'action' => 'nosDialog',
                'dialog' => array(
                    'ajax' => true,
                    'contentUrl' => 'admin/my_app/my_controller/export',
                    'title' => 'Export datas',
                ),
            ),
            'label' => 'Export datas',
            'icon' => 'arrowstop-1-n',
        ),
    ),

You can see how configure your custom action here : http://docs-api.novius-os.org/en/latest/php/configuration/application/common.html#actions

The keys `targets`, `disable` and `visible` are not take in count.