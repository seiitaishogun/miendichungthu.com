<?php

/**
 * @param $slug slug of widget
 * @return mixed
 */
function widget($slug) {
    return optional(
        (new \Modules\Widget\Libraries\Widget())->setWidgetModel($slug)
    )->render();
}
