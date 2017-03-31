<?php

namespace evgeniyrru\yii2slick;

use yii\base\Widget;
use yii\helpers\Html;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\View;
use yii\web\JsExpression;

/**
 * This is a wrapper for Slick Carousel plugin
 * @see http://kenwheeler.github.io/slick/
 *
 *
 * @author Evgeniy Chernishev <EvgeniyRRU@gmail.com>
 */
class Slick extends Widget
{

    /**
     * @var array options to call an event such as "init", "destroy", etc..
     */
    public $events = [];

    /**
     * @var array options to populate Slick jQuery object
     */
    public $clientOptions = [];

    /**
     * @var integer position for inclusion javascript widget code to web page
     * @link http://www.yiiframework.com/doc-2.0/yii-web-view.html#registerJs()-detail
     */
    public $jsPosition = View::POS_READY;

    /**
     * @var array HTML attributes to render on the container
     */
    public $containerOptions = [];

    /**
     * @var string HTML tag to render the container
     */
    public $containerTag = 'div';

    /**
     * @var string HTML tag to render items for the carousel
     */
    public $itemContainer = 'div';

    /**
     * @var array HTML attributes for the one item
     */
    public $itemOptions = [];

    /**
     * @var array elements for the carousel
     */
    public $items = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->normalizeOptions();

        // not allowed empty Items
        if(empty($this->items)) {
            throw new Exception('Not allowed without items');
        }
    }

    /**
     * Preparing some options for this widgets
     */
    protected function normalizeOptions()
    {
        // not allowed empty container
        !$this->containerTag && $this->containerTag = 'div';

        if(!isset($this->containerOptions['id']) || empty($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->getId();
        }
    }

    /**
     * Register required scripts for the Slick plugin
     */
    protected function registerClientScript()
    {
        $view = $this->getView();

        SlickAsset::register($view);

        $options = Json::encode($this->clientOptions);

        $id = $this->containerOptions['id'];

        $js[] = ";";

        $js[] = "jQuery('#$id').slick($options);";

        $view->registerJs(implode(PHP_EOL, $js), $this->jsPosition);

        foreach ($this->events as $key => $value) {
            $view->registerJs(new JsExpression("$('#".$this->id."').on('".$key."', ".$value.");"), $this->jsPosition);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $slider = Html::beginTag($this->containerTag, $this->containerOptions);

        foreach($this->items as $item) {
            $slider .= Html::tag($this->itemContainer, $item, $this->itemOptions);
        }

        $slider .= Html::endTag($this->containerTag);
        echo $slider;
        $this->registerClientScript();
    }

}
