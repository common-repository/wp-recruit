<?php

/**
* Plugin Name: Eezy Recruit
* Description: Connect your website with recruit listings
* Version: 1.0
* Author: Eddy Salzmann
* Author URI: http://eddysalzmann.com/
* Text Domain: recruit
**/

defined( 'ABSPATH' ) || exit;


add_action('wp_enqueue_scripts', 'eezy_recruit_jobs_enqueue_script');
function eezy_recruit_jobs_enqueue_script() {   

  wp_enqueue_script('eezy-recruit-script', plugins_url('eezy-recruit.js', __FILE__) , array( 'jquery' ), true);
	wp_enqueue_style( 'eezy-recruit-style', plugins_url('eezy-recruit.css', __FILE__) );
	
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'eezy_recruit_add_action_links' );

function eezy_recruit_add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'options-general.php?page=eezy-recruit' ) . '">Settings</a>',
 );
return array_merge( $links, $mylinks );
}


class eezyRecruitSettings
{

    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'eezy_recruit_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'eezy_recruit_page_init' ) );
    }

    /**
     * Add options page
     */
    public function eezy_recruit_add_plugin_page()
    {
        add_options_page(
            'Eezy Recruit', 
            'Eezy Recruit', 
            'manage_options', 
            'eezy-recruit', 
            array( $this, 'eezy_recruit_create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function eezy_recruit_create_admin_page()
    {
        $this->options = get_option( 'eezy_recruit_option_name' );
        ?>
        <div class="wrap">
            <h1>Eezy Recruit Settings</h1>
            <form method="post" action="options.php">
            <?php
							settings_fields('eezy_recruit_option_group');
							do_settings_sections('eezy-recruit-settings-admin');
							submit_button();
						?>
            </form>
        </div>
        <?php
}

/**
 * Register and add settings
 */
public function eezy_recruit_page_init()
{
    register_setting('eezy_recruit_option_group',
    'eezy_recruit_option_name',
    array(
        $this,
        'eezy_recruit_sanitize'
    )
    );

    add_settings_section('setting_section_id',
    'Account',
    array(
        $this,
        'eezy_recruit_print_section_info'
    ) ,
    'eezy-recruit-settings-admin'
    
    );

    add_settings_field('eezy_recruit_platform',
    'Platform',
    array(
        $this,
        'eezy_recruit_platform_callback'
    ) , 'eezy-recruit-settings-admin', 'setting_section_id');

    add_settings_field('eezy_recruit_id',
    'User ID',
    array(
        $this,
        'eezy_recruit_id_callback'
    ) , 'eezy-recruit-settings-admin', 'setting_section_id');

    register_setting('eezy_recruit_option_group_2',
    'eezy_recruit_option_name_2',
    array(
        $this,
        'eezy_recruit_sanitize'
    )
    );

    add_settings_section('setting_section_id_2',
    'Lists',
    array(
        $this,
        'eezy_recruit_print_section_info_2'
    ) ,
    'eezy-recruit-settings-admin'
    
    );

    add_settings_field('eezy_recruit_position', 'Position', array(
        $this,
        'eezy_recruit_position_callback'
    ) , 'eezy-recruit-settings-admin', 'setting_section_id_2');
    add_settings_field('eezy_recruit_department', 'Department', array(
        $this,
        'eezy_recruit_department_callback'
    ) , 'eezy-recruit-settings-admin', 'setting_section_id_2');
    add_settings_field('eezy_recruit_location', 'Location', array(
        $this,
        'eezy_recruit_location_callback'
    ) , 'eezy-recruit-settings-admin', 'setting_section_id_2');

    add_settings_field('eezy_recruit_button', 'Apply button', array(
        $this,
        'eezy_recruit_button_callback'
    ) , 'eezy-recruit-settings-admin', 'setting_section_id_2');

}

/**
 * Sanitize each setting field as needed
 *
 * @param array $input Contains all settings fields as array keys
 */
public function eezy_recruit_sanitize($input)
{
    $new_input = array();
    if (isset($input['eezy_recruit_id'])) $new_input['eezy_recruit_id'] = sanitize_text_field($input['eezy_recruit_id']);

    if (isset($input['eezy_recruit_position'])) $new_input['eezy_recruit_position'] = sanitize_text_field($input['eezy_recruit_position']);

    if (isset($input['eezy_recruit_department'])) $new_input['eezy_recruit_department'] = sanitize_text_field($input['eezy_recruit_department']);

    if (isset($input['eezy_recruit_location'])) $new_input['eezy_recruit_location'] = sanitize_text_field($input['eezy_recruit_location']);

    if (isset($input['eezy_recruit_button'])) $new_input['eezy_recruit_button'] = sanitize_text_field($input['eezy_recruit_button']);

    if (isset($input['eezy_recruit_platform'])) $new_input['eezy_recruit_platform'] = sanitize_text_field($input['eezy_recruit_platform']);

    return $new_input;
}

/** 
 * Print the Section text
 */
public function eezy_recruit_print_section_info()
{
    //print 'Enter your settings below:';
}

public function eezy_recruit_print_section_info_2()
{
    print 'Change job listing texts';
}

/** 
 * Get the settings option array and print one of its values
 */
public function eezy_recruit_id_callback()
{
    printf('<input type="text" id="eezy_recruit_id" name="eezy_recruit_option_name[eezy_recruit_id]" value="%s" />
            <p class="description">Hire needs your Company Domain name (eg "dromae") and for Personio write "myname" for https://<strong>myname</strong>-jobs.personio.de/</p>', isset($this->options['eezy_recruit_id']) ? esc_attr($this->options['eezy_recruit_id']) : '');
}
public function eezy_recruit_position_callback()
{
    printf('<input type="text" placeholder="Position" id="eezy_recruit_position" name="eezy_recruit_option_name[eezy_recruit_position]" value="%s" />
            <p class="description">Changes the job listings table header text</p>', isset($this->options['eezy_recruit_position']) ? esc_attr($this->options['eezy_recruit_position']) : '');
}

public function eezy_recruit_department_callback()
{
    printf('<input type="text" placeholder="Department" id="eezy_recruit_department" name="eezy_recruit_option_name[eezy_recruit_department]" value="%s" />
            <p class="description">Changes the job listings table header text</p>', isset($this->options['eezy_recruit_department']) ? esc_attr($this->options['eezy_recruit_department']) : '');
}

public function eezy_recruit_location_callback()
{
    printf('<input type="text" placeholder="Location" id="eezy_recruit_location" name="eezy_recruit_option_name[eezy_recruit_location]" value="%s" />
            <p class="description">Changes the job listings table header text</p>', isset($this->options['eezy_recruit_location']) ? esc_attr($this->options['eezy_recruit_location']) : '');
}

public function eezy_recruit_button_callback()
{
    printf('<input type="text" placeholder="Apply now" id="eezy_recruit_button" name="eezy_recruit_option_name[eezy_recruit_button]" value="%s" />
            <p class="description">Changes the job listings apply button text</p>', isset($this->options['eezy_recruit_button']) ? esc_attr($this->options['eezy_recruit_button']) : '');
}

public function eezy_recruit_platform_callback()
{

    $items = array(
        "Hire by Google",
        "Personio"
    );
    echo "<select id='eezy_recruit_platform' name='eezy_recruit_option_name[eezy_recruit_platform]'>";
    foreach ($items as $item)
    {
        $selected = ($this->options['eezy_recruit_platform'] == $item) ? 'selected="selected"' : '';
        echo '<option value="' . $item . '" ' . $selected . '>' . $item . '</option>';
    }
    echo "</select>";
}

}

if (is_admin())
{
    $eezy_recruit_settings_page = new eezyRecruitSettings();
}

add_shortcode("recruit", "eezy_recruit_shortcode");
function eezy_recruit_shortcode($atts) {
	ob_start();
	
	$a = shortcode_atts( array(
      'platform' => '',
      'user' => '',
      'align' => '',
  ), $atts );
  
  $platform = "";
  $user = "";
  $align = "";
  
  $options = get_option('eezy_recruit_option_name');
  
  if(isset($options["eezy_recruit_id"]) && $options["eezy_recruit_id"] !== ""){
  	$user = $options["eezy_recruit_id"];
  }
  if(esc_attr($a['user']) && esc_attr($a['user']) !== ""){
  	$user = esc_attr($a['user']);
  }
  
  if(isset($options["eezy_recruit_platform"]) && $options["eezy_recruit_platform"] !== ""){
  	$platform = $options["eezy_recruit_platform"];
  }
  
  if(esc_attr($a['platform']) && esc_attr($a['platform']) !== ""){
  	$platform = esc_attr($a['platform']);
  }
  
  if(esc_attr($a['align']) && esc_attr($a['align']) !== ""){
  	$align = esc_attr($a['align']);
  }
  
  if($user == ""){
  	echo '<center><i><strong>' . $platform . ' ' . __('Warning','eezy-recruit') . '</strong>: ' . __('Please provide a User ID on the Recruit settings page.','eezy-recruit') . '</i></center>';
  }
  
  else{
	
		if($platform == "Hire by Google"){
		
			$url = "https://hire.withgoogle.com/v2/api/t/".$user."/public/jobs";
			
			$response = wp_remote_get( $url );
			$http_code = wp_remote_retrieve_response_code( $response );
			$result = wp_remote_retrieve_body( $response );
			
			$url_exists = true;

			if(!isset($http_code) || $http_code !== 200){
				$url_exists = false;
			}
			
			if($url_exists) {
				
				$jobs_array = array();
				
				foreach(json_decode($result, true) as $thing){
					
					$job_array = array();
					
					$department = "Others";
					if(isset($thing["hiringOrganization"]["department"]["name"]) && $thing["hiringOrganization"]["department"]["name"] !== ""){
						$department = $thing["hiringOrganization"]["department"]["name"];
					}
					$job_array['department'] = $department;
		
					if(isset($thing["employmentType"])){
						$job_array['type'] = $thing["employmentType"];
					}
					if(isset($thing["title"])){
						$job_array['title'] = $thing["title"];
					}
					if(isset($thing["description"])){
						$job_array['description'] = $thing["description"];
					}
					if(isset($thing["url"])){
						$job_array['url'] = $thing["url"];
					}
					if(isset($thing["estimatedSalary"])){
						$job_array['estimatedSalary'] = $thing["estimatedSalary"];
					}
					if(isset($thing["jobLocation"])){
						$location = $thing["jobLocation"];
						if(isset($location["address"])){
							$address = $location["address"];
						}
						$locality = NULL;
						$country = NULL;
						$addresses = "";
						
						if(isset($address["addressLocality"])){
							$locality = $address["addressLocality"];
						}
						if(isset($address["addressCountry"])){
							$country = $address["addressCountry"];
							$country = Locale::getDisplayRegion('-' . $country, 'en');
						}
						if($locality){
							$addresses .= $locality;
						}
						if($locality && $country){
							$addresses .= ", ";
						}
						if($country){
							$addresses .= $country;
						}
						$job_array['locality'] = $addresses;	
					}
	
					$jobs_array[] = $job_array;
				}
	
				echo eezy_recruit_hire_template($jobs_array,$align);
				
			}else{
				echo eezy_recruit_connection_warning($platform,$user);
			}
		
		}
		
		if($platform == "Personio"){
			
			$url = 'https://' . $user . '-jobs.personio.de/xml';
			
			$url_exists = true;
			$test = @simplexml_load_file($url);
			if ($test === false) {
			  $url_exists = false;
			}

			if($url_exists){
				$lang = 'en';
				$positions = simplexml_load_file($url);
				echo eezy_recruit_personio_template($positions,$user,$align);
			}else{
				echo eezy_recruit_connection_warning($platform,$user);	
			}
			
		}
	
	}
				
	return ob_get_clean();
}

function eezy_recruit_connection_warning($platform,$user){	
	if($user !== ""){
		$user = '"'.$user.'"';
	}
	return sprintf(__('<center><i><strong>%s warning</strong>: There seems to be a problem with your User ID %s. Please try another one.','eezy-recruit'),$platform,$user);
}


function eezy_recruit_currency_symbol($currencyCode, $locale = 'en_US'){
    $formatter = new \NumberFormatter($locale . '@currency=' . $currencyCode, \NumberFormatter::CURRENCY);
    return $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
}


function eezy_recruit_hire_template($jobsarray,$align = ""){
	
	if($align && $align !== ""){
		$align = " align" . $align;
	}
	
	$output = '<div class="eezy-recruit'.$align.'">';
			
		$position = 'Position';
		$department = 'Department';
		$location = 'Location';
		
		if(isset($options["eezy_recruit_position"]) && $options["eezy_recruit_position"] !== ""){
	  	$position = $options["eezy_recruit_position"];
	  }
	  if(isset($options["eezy_recruit_department"]) && $options["eezy_recruit_department"] !== ""){
	  	$department = $options["eezy_recruit_department"];
	  }
	  if(isset($options["eezy_recruit_location"]) && $options["eezy_recruit_location"] !== ""){
	  	$location = $options["eezy_recruit_location"];
	  }
		
		$output .= '<div class="eezy-recruit-list-header">
									<div class="row-1">'.$position.'</div>
									<div class="row-2">'.$department.'</div>
									<div class="row-3">'.$location.'</div>
								</div>
								<div class="eezy-recruit-list-content">';
		
		foreach($jobsarray as $jobarray){
			
			$description = "";
			
			if(isset($jobarray['description'])){
				$description = $jobarray['description'];
			}
			
			$output .= '<div class="eezy-recruit-single-accordion">';
				$output .= '<div class="eezy-recruit-single-header">';
					
					$output .= '<div class="name row-1">' . $jobarray['title'];

					if(isset($jobarray['type']) || isset($jobarray['estimatedSalary'])){
						
						$output .= '<br><span class="meta">';

						if(isset($jobarray['estimatedSalary'])){
							
							$salary = $jobarray['estimatedSalary'];

							if(isset($salary['currency'])){
								$output .= eezy_recruit_currency_symbol($salary['currency']);
							}
							if(isset($salary['value'])){
								$output .= $salary['value'];
							}
							
							if($salary['value'] > 999){
								$output .= " / year";
							}else{
								$output .= " / hour";
							}
						}
						
						if(isset($jobarray['type']) && isset($jobarray['estimatedSalary'])){
							$output .= ' - ';
						}
						
						if(isset($jobarray['type'])){
							$output .= $jobarray['type'];
						}
						
						$output .= '</span>';
					
					}
					
					$output .= '</div>';
					
					$output .= '<div class="name row-2">';
						if(isset($jobarray['department'])){
							$output .= $jobarray['department'];
						}else{
							$output .= "-";
						}
					$output .= '</div>';
					$output .= '<div class="location row-3">' .$jobarray['locality'].'</div>';
				$output .= '</div>';
				$output .= '<div class="eezy-recruit-single-detail hidden">';
					$output .= '<div class="eezy-recruit-single-detail-inner">';
						$output .= strip_tags($description,'<br>');
						$output .= '<br><br><a class="btn btn-small" href="'.$jobarray['url'].'" target="_blank">';
						
						$button_text = "Apply now";
						
						if(isset($options["eezy_recruit_button"]) && $options["eezy_recruit_button"] !== ""){
					  	$button_text = $options["eezy_recruit_button"];
					  }
						
						$output .= $button_text . '</a>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		}
		
		$output .= '</div>';
	
	$output .= '</div>';
	
	return $output;
	
}

function eezy_recruit_personio_template($positions, $hostname, $align, $lang = "en"){
	
	if($align && $align !== ""){
		$align = " align" . $align;
	}
	
	$output = '<div class="eezy-recruit'.$align.'">';
			
		$position = 'Position';
		$department = 'Department';
		$location = 'Location';
		
		if(isset($options["eezy_recruit_position"]) && $options["eezy_recruit_position"] !== ""){
	  	$position = $options["eezy_recruit_position"];
	  }
	  if(isset($options["eezy_recruit_department"]) && $options["eezy_recruit_department"] !== ""){
	  	$department = $options["eezy_recruit_department"];
	  }
	  if(isset($options["eezy_recruit_location"]) && $options["eezy_recruit_location"] !== ""){
	  	$location = $options["eezy_recruit_location"];
	  }
		
		$output .= '<div class="eezy-recruit-list-header">
									<div class="row-1">'.$position.'</div>
									<div class="row-2">'.$department.'</div>
									<div class="row-3">'.$location.'</div>
								</div>
								<div class="eezy-recruit-list-content">';
		
		$categories = [];
		foreach ($positions->position as $position){
			$category = (string)$position->recruitingCategory;
			if($category && !in_array($category, $categories)){
				$categories[] = $category;
			}
		}
		$translations = [
			"full-time" => 	[
				"en" => __("Full-time","recruit")
			],
			"part-time" =>  [
              "en" => __("Part-time","recruit")
      ],
			"permanent" =>  [
              "en" => __("Permanent Employment","recruit")
      ],
			"intern" =>  [
              "en" => __("Internship","recruit")
      ],
			"trainee" =>  [
              "en" => __("Trainee Stelle","recruit")
      ],
			"freelance" =>  [
              "en" => __("Freelance Position","recruit")
      ],
		];
	
		// Print job postings
		foreach ($positions as $position) {

			$descriptions = "";
			
			foreach($position->jobDescriptions->jobDescription as $description){
				$descriptions .= $description->value;
			}
			
			$detailLink = 'https://' . $hostname . '-jobs.personio.de/job/' . $position->id;
			
			$output .= '<div class="eezy-recruit-single-accordion">';
				$output .= '<div class="eezy-recruit-single-header">';
					
					$output .= '<div class="name row-1">' . $position->name;
					$output .= '<br><span class="meta">' . $translations[(string)$position->employmentType][$lang] . ', ' . $translations[(string)$position->schedule][$lang]. '</span>';
					$output .= '</div>';
					
					$output .= '<div class="name row-2">' . $position->department . '</div>';
					
					$output .= '<div class="location row-3">' .$position->office.'</div>';
				$output .= '</div>';
				$output .= '<div class="eezy-recruit-single-detail hidden">';
					$output .= '<div class="eezy-recruit-single-detail-inner">';
						$output .= preg_replace('#(<\s*br[^/>]*/?\s*>\s*){3,}#is',"<br />\n",$descriptions);
						$output .= '<br><br><a class="btn btn-small" href="'.$detailLink.'" target="_blank">';
						
						$button_text = "Apply now";
						
						if(isset($options["eezy_recruit_button"]) && $options["eezy_recruit_button"] !== ""){
					  	$button_text = $options["eezy_recruit_button"];
					  }
						
						$output .= $button_text . '</a>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		}
		
		$output .= '</div>';
	
	$output .= '</div>';
	
	return $output;
	
}


