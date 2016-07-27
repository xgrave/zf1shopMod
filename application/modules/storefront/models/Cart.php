<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/25/16
 * Time: 4:47 PM
 */
class Storefront_Model_Cart extends SF_Model_Abstract implements SeekableIterator, Countable, ArrayAccess
{
    protected $_items = array();
    protected $_subTotal = 0;
    protected $_total = 0;
    protected $_shipping = 0;
    protected $_sessionNamespace;

    public function init()
    {
        $this->loadSession();
    }

    public function addItem(
        Storefront_Resource_Product_Item_Interface $product, $qty
    )
    {
        if(0 > $qty){
            return false;
        }
        if(0 == $qty){
            $this->removeItem($product);
            return false;
        }

        $item = new Storefront_Resource_Cart_Item(
            $product, $qty
        );

        $this->_items[$item->productId] = $item;
        $this->persist();
        return $item;
    }

    public function removeItem($product)
    {
        if(is_int($product)){
            unset($this->_items[$product]);
        }

        if($product instanceof Storefront_Resource_Product_Item_Interface){
            unset($this->_items[$product->productId]);
        }

        $this->persist();
    }

    public function setSessionNs(Zend_Session_Namespace $ns)
    {
        $this->_sessionNamespace = $ns;
    }

    public function getSessionNs()
    {
        if(null === $this->_sessionNamespace){
            $this->setSessionNs(new Zend_Session_Namespace(__CLASS__));
        }
        return $this->_sessionNamespace;
    }

    public function persist()
    {
        $this->getSessionNs()->items = $this->_items;
        $this->getSessionNs()->shipping = $this->getShippingCost();
    }

    public function loadSession()
    {
        if(isset($this->getSessionNs()->items)){
            $this->_items = $this->getSessionNs()->items;
        }

        if(isset($this->getSessionNs()->shipping)){
            $this->setShippingCost($this->getSessionNs()->shipping);
        }
    }

    public function calculateTotals()
    {
        $sub = 0;
        foreach($this as $item){
            $sub = $sub + $item->getLineCost();
        }
        $this->_subTotal = $sub;
        $this->_total = $this->_subTotal + (float) $this->_shipping;
    }

    public function setShippingCost($cost)
    {
        $this->_shipping = $cost;
        $this->CalculateTotals();
        $this->persist();
    }

    public function getShippingCost()
    {
        $this->CalculateTotals();
        return $this->_shipping;
    }

    public function getSubTotal()
    {
        $this->CalculateTotals();
        return $this->_subTotal;
    }

    public function getTotal()
    {
        $this->calculateTotals();
        return $this->_total;
    }

    //include prebuilt from tutorial to extend  core php classes
    /**
     * Does the given offset exist?
     *
     * @param string|int $key key
     * @return boolean offset exists?
     */
    public function offsetExists($key)
    {
        return isset($this->_items[$key]);
    }

    /**
     * Returns the given offset.
     *
     * @param string|int $key key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->_items[$key];
    }

    /**
     * Sets the value for the given offset.
     *
     * @param string|int $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        return $this->_items[$key] = $value;
    }

    /**
     * Unset the given element.
     *
     * @param string|int $key
     */
    public function offsetUnset($key)
    {
        unset($this->_items[$key]);
    }

    /**
     * Returns the current row.
     *
     * @return array|boolean current row
     */
    public function current()
    {
        return current($this->_items);
    }

    /**
     * Returns the current key.
     *
     * @return array|boolean current key
     */
    public function key()
    {;
        return key($this->_items);
    }

    /**
     * Moves the internal pointer to the next item and
     * returns the new current item or false.
     *
     * @return array|boolean next item
     */
    public function next()
    {
        return next($this->_items);
    }

    /**
     * Reset to the first item and return.
     *
     * @return array|boolean first item or false
     */
    public function rewind()
    {
        return reset($this->_items);
    }

    /**
     * Is the pointer set to a valid item?
     *
     * @return boolean valid item?
     */
    public function valid()
    {
        return current($this->_items) !== false;
    }

    /**
     * Seek to the given index.
     *
     * @param int $index seek index
     */
    public function seek($index)
    {
        $this->rewind();
        $position = 0;

        while ($position < $index && $this->valid()) {
            $this->next();
            $position++;
        }

        if (!$this->valid()) {
            throw new SF_Model_Exception('Invalid seek position');
        }
    }

    /**
     * Count the cart items
     *
     * @return int row count
     */
    public function count()
    {
        return count($this->_items);
    }
}