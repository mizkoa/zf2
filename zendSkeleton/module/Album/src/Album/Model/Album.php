<?php
/*
 * 
 * This is the Model Class object which represents the Entity (table in the DB)
 * This model class which represents the entity, will be mapped by another object ==> AlbumTable.php 
 * 
 * 
 * Aug.13, 2013 @mrod
 */

namespace Album\Model;
// <!-- Classes are requered for validation! 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
//-!>



// Zend Framework2 validation is done using an input filter, which can either be standalone or defined within any class that implements the InputFilterAwareInterface interface, such as a model entity.
class Album implements InputFilterAwareInterface
{
    public $id;
    public $artist;
    public $title;
    protected $inputFilter ; 
    
/*
 * In order to work with Zend\Db’s TableGateway class, we need to implement the exchangeArray() method. 
 * This method simply copies the data from the passed in array to our entity’s properties
 * Retrieving data from the model and putting data back into the model are done using a hydrator object (http://www.webconsults.eu/blog/entry/108-What_is_a_Hydrator_in_Zend_Framework_2)-
 * There are a number of hydrators, but the default one is Zend\Stdlib\Hydrator\ArraySerializable which expects to find two methods in the model: 
 * - getArrayCopy() 
 * - exchangeArray()
 * The hydrators are mostly build for usage with Form and DataTable objects, mostly at any point where you need to transfer an object from an array, or any other type of data.
 * Conclusion : Transforming an Object into Array Data (extract) or the other way arround (hydrate)
 */
    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
 // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'artist',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    

 
}
?>
