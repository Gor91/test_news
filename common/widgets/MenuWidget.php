<?php

namespace common\widgets;

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\widgets\Menu;

class MenuWidget extends Menu
{
    public $linkTemplate = '<a onclick="getNews({catId})" href="{url}">{label}</a>';

    /**
     * @return string|void
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function run()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setHeaders(['Authorization' => sprintf('Bearer %s', \Yii::$app->user->identity->token)])
            ->setUrl(sprintf('%s/v1/category', Url::home(true)))
            ->send();

        if ($response->isOk) {
            $this->items = $this->menuTree($response->data);
        }

        echo parent::run();
    }

    /**
     * @param $items
     * @param null $parent_id
     * @return array
     */
    function menuTree($items, $parent_id = null)
    {
        $menu = [];

        foreach ($items as $item) {
            if ($item['parent_id'] == $parent_id) {
                $item['label'] = $item['title'];
                $item['url'] = '#';
                $item['catId'] = $item['id'];
                $sub_items = $this->menuTree($items, $item['id']);

                if ($sub_items) {
                    $item['items'] = $sub_items;
                }

                $menu[] = $item;
            }
        }

        return $menu;
    }

    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{catId}' => $item['catId'],
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }
}
