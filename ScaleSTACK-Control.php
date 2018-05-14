<?php
/**
 * * @package Entasis_Plugins
 * * @version 1.1
 * */
/*
 * Plugin Name: ScaleSTACK Control
 * Plugin URI: http://entasistech.com
 * Description: This is the plugin to view dashboard information for your ScaleSTACK deployment.
 * Author: Entasis Technology Consulting
 * Version: 1.1
 * Author URI: http://entasistech.com
 * */

add_action('wp_head', 'scalestack_health_check');
function scalestack_health_check() {
	?>
    <!--Powered by: ScaleSTACK-->
		<?php
}

$devenv = getenv('SCALESTACK_INSTANCE_ENV');
if ($devenv == 'dev'){
add_action('wp_head', 'scalestack_dev_check');
function scalestack_dev_check() {
	if (is_front_page()){
	?>
	<script>
  $(document).ready(function(){
    alert('You are on the DEV site!');
  });
</script>
	<?php
} } }

add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	        add_menu_page( 'ScaleSTACK Control Plane', 'ScaleSTACK', 'manage_options', 'ScaleSTACK-Control', 'myplugin_admin_page', 'dashicons-cloud', 0  );
}

function myplugin_admin_page(){
	        ?>
        <div class="wrap">
                <img src="/wp-content/plugins/ScaleSTACK-Control/images/ScaleSTACK-Wordpress.png" alt="ScaleSTACK Logo">
                <div class="section group">
                        <?php include('includes/AccordionScale.php');?>

                </div>
        </div>

        <style>
        .wrap h2        { color:#002756; }
        .span_1_of_3 h3 { padding-left:20px !important; color:#002756; font-size:18px; }
        .span_1_of_3 p  { padding-left:20px !important; }
/*  SECTIONS  */
        .section {
        clear: both;
        padding: 0px;
        margin: 0px;
        }
/*  GROUPING  */
        .group:before,
        .group:after { content:""; display:table; }
        .group:after { clear:both;}
        .group { zoom:1; /* For IE 6/7 */ }
        </style>

<?php
}

add_action( 'admin_menu', 'my_admin_submenu' );
function my_admin_submenu() {
    add_submenu_page('ScaleSTACK-Control', 'AWS CloudWatch Logs', 'AWS CloudWatch Logs', 'manage_options', 'aws-cloudwatch-logs', 'aws_cloudwatch_logs' );
}

function aws_cloudwatch_logs() {

	?>

<p>AWS CloudWatch Logs</p>
<?php
}
$date = date('YYYYMMDD');
$starttime = strtotime ( '-8 hour' , strtotime ( $date ) ) ;
$starttime = date ( 'Y-m-j' , $starttime );
$endtime = strtotime("now");
$result = $client->getLogEvents([
    'endTime' => $endtime,
    'limit' => 25,
    'logGroupName' => '/ecs/dev-obrerofiel-com', // REQUIRED
    'logStreamName' => 'ecs/dev-obrerofiel-com/06f2f293-8fb9-4a48-9fff-cd7b81331c7f', // REQUIRED
    //'nextToken' => '<string>',
    'startFromHead' => false,
    'startTime' => $starttime,
]);
/*$date = date('YYYYMMDD');
$starttime = strtotime ( '-8 hour' , strtotime ( $date ) ) ;
$starttime = date ( 'Y-m-j' , $starttime );
$endtime = strtotime("now");
$result = $client->getLogEvents(array(
    'logGroupName' => '/ecs/dev-obrerofiel-com',
    'logStreamName' => 'ecs/dev-obrerofiel-com/06f2f293-8fb9-4a48-9fff-cd7b81331c7f',
    'startTime' => $starttime,
    'endTime' => $endtime,
    'nextToken' => 'nextForwardToken',
    'limit' => 25,
    'startFromHead' => true || false,
));
*/
/* add_action( 'wp_dashboard_setup', 'register_my_dashboard_widget' );
function register_my_dashboard_widget() {
	        global $wp_meta_boxes;
		        wp_add_dashboard_widget(
				                'my_dashboard_widget',
						                'ScaleSTACK Control Plane Preview',
								                'my_dashboard_widget_display'
										        );

$dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

        $my_widget = array( 'my_dashboard_widget' => $dashboard['my_dashboard_widget'] );
        unset( $dashboard['my_dashboard_widget'] );

	        $sorted_dashboard = array_merge( $my_widget, $dashboard );
	        $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
		}

add_action( 'wp_dashboard_setup', 'register_my_dashboard_widget' );

function my_dashboard_widget_display() {

?>
<p>Welcome to the ScaleSTACK Control dashboard! Need help? Contact Entasis <a href="http://www.entasistech.com">here</a>.</p>
<p><a href="admin.php?page=ScaleSTACK-Control.php">Update your settings</a></p>
<p><strong>Your Environment:</strong> <?php echo getenv('HOSTNAME');?></p>
<?

	}
	*/

function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=ScaleSTACK-Control.php">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
        return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

include('includes/relativeurls.php');
include('includes/securitystack.php');
include('includes/featurestack.php');
include('salt-shaker/shaker.php');

?>
<?php } ?>
