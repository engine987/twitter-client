<h3>Search for tweets</h3>
<?php
    echo $this->Form->create('twitter-form', ['url' => ['action' => 'get-tweets']]);
    echo $this->Form->text('search');
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();

    echo $this->Html->tag('hr');
    if (isset($tweets) && count($tweets) > 0) {
        foreach ($tweets as $tweet) {
             echo $this->element('panel', compact('tweet'));
        }
    } else {
        echo $this->Html->tag('h3', 'No data found');
    }

