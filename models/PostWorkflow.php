<?php

namespace app\models;

class PostWorkflow implements \raoul2000\workflow\source\file\IWorkflowDefinitionProvider
{
    public function getDefinition() {
        return [
            'initialStatusId' => 'draft',
            'status' => [
                'draft' => [
                    'transition' => ['correction']
                ],
                'correction' => [
                    'transition' => ['draft','ready']
                ],
                'ready' => [
                    'transition' => ['draft', 'correction', 'published']
                ],
                'published' => [
                    'transition' => ['ready', 'archived']
                ],
                'archived' => [
                    'transition' => ['ready']
                ]
            ]
        ];
    }
}