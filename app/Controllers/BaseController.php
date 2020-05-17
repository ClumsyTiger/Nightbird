<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
            // Do Not Edit This Line
            parent::initController($request, $response, $logger);

            //--------------------------------------------------------------------
            // Preload any models, libraries, etc, here.
            //--------------------------------------------------------------------
            // E.g.:
            
            // pokretanje sesije
            $this->session = \Config\Services::session();
	}

        /**
         * decode the received JSON message body from the AJAX request and return it as an PHP associative array
         * 
         * @return associative array
         */
        protected function receiveAJAX()
        {
            // get the data from the JSON message body
            $data = $this->request->getJSON(true);
            // get the method used to send the request
            $method = '_'.strtoupper($this->request->getMethod());
            
            // overwrite the superglobal request method array
            $GLOBALS[$method] = $data;
            // overwrite the request superglobal array (the array that gets its values from the actual request method array)
            $GLOBALS['_REQUEST'] = $data;
            
            // return the message data
            return $data;
        }
        
        /*
         * encode the given data as a JSON object and send an AJAX response to the client
         * this method doesn't check if the $data is convertible to JSON
         * 
         * @param data -- the data that will be sent as the response
         */
        protected function sendAJAX($data)
        {
            // set the JSON response data and send it to the client
            $this->response->setJSON($data)->send();
        }
        
}
