<?php


/**
 * Class Concat_Endpoint
 */
class Concat_Endpoint {

	/**
	 * @var string
	 */
	private $slug = '_static';

	/**
	 *
	 */
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
		add_action( 'redirect_canonical', array( $this, 'canonical' ) );
	}

	/**
	 *
	 */
	public function init() {
		add_rewrite_endpoint( $this->get_slug(), EP_ROOT );
	}

	/**
	 *
	 */
	function template_redirect() {
		if ( get_query_var( $this->get_slug() ) ) {
			require_once "http-concat.php";
			exit();
		}
	}

	/**
	 * Hook into redirect_canonical to stop trailing slashes on sitemap.xml URLs
	 *
	 * @param string $redirect The redirect URL currently determined.
	 *
	 * @return bool|string $redirect
	 */
	public function canonical( $redirect ) {
		$_static = get_query_var( $this->get_slug() );
		if ( ! empty( $_static ) ) {
			return false;
		}
		return $redirect;
	}

	/**
	 * @return string
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 * @param string $name
	 */
	public function set_slug( $slug ) {
		$this->slug = $slug;
	}
}

$concat_endpoint = new Concat_Endpoint();