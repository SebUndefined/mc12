<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 20/09/17
 * Time: 10:22
 */

namespace MC12\SubscriptionBundle\Stripe;


class ConfigStripe
{
    private $pubKey;
    private $privKey;

    /**
     * ConfigStripe constructor.
     *
     */
    public function __construct()
    {
        $this->pubKey = "pk_test_5MXU6aHa9Fg21xKR94SAJEuF";
        $this->privKey = "sk_test_w6c08hlVovROi2TAcjtDglUM";
    }
    /**
     * @return mixed
     */
    public function getPubKey()
    {
        return $this->pubKey;
    }

    /**
     * @param mixed $pubKey
     */
    public function setPubKey($pubKey)
    {
        $this->pubKey = $pubKey;
    }

    /**
     * @return mixed
     */
    public function getPrivKey()
    {
        return $this->privKey;
    }

    /**
     * @param mixed $privKey
     */
    public function setPrivKey($privKey)
    {
        $this->privKey = $privKey;
    }

}