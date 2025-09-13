<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function getTemplates()
    {
        return [
            'tutorial' => [
                'name' => 'Tutorial',
                'description' => 'Template untuk tutorial step-by-step',
                'sections' => [
                    ['type' => 'overview', 'title' => 'Overview', 'required' => true],
                    ['type' => 'prerequisites', 'title' => 'Prerequisites', 'required' => true],
                    ['type' => 'step', 'title' => 'Step 1: Setup', 'required' => true],
                    ['type' => 'step', 'title' => 'Step 2: Implementation', 'required' => true],
                    ['type' => 'step', 'title' => 'Step 3: Testing', 'required' => false],
                    ['type' => 'conclusion', 'title' => 'Conclusion', 'required' => true],
                ]
            ],
            'tips' => [
                'name' => 'Tips & Tricks',
                'description' => 'Template untuk tips dan trik',
                'sections' => [
                    ['type' => 'introduction', 'title' => 'Introduction', 'required' => true],
                    ['type' => 'tip', 'title' => 'Tip 1', 'required' => true],
                    ['type' => 'tip', 'title' => 'Tip 2', 'required' => false],
                    ['type' => 'tip', 'title' => 'Tip 3', 'required' => false],
                    ['type' => 'summary', 'title' => 'Summary', 'required' => true],
                ]
            ],
            'review' => [
                'name' => 'Review',
                'description' => 'Template untuk review tools/framework',
                'sections' => [
                    ['type' => 'introduction', 'title' => 'Introduction', 'required' => true],
                    ['type' => 'pros', 'title' => 'Pros', 'required' => true],
                    ['type' => 'cons', 'title' => 'Cons', 'required' => true],
                    ['type' => 'comparison', 'title' => 'Comparison', 'required' => false],
                    ['type' => 'verdict', 'title' => 'Final Verdict', 'required' => true],
                ]
            ],
            'guide' => [
                'name' => 'Complete Guide',
                'description' => 'Template untuk panduan lengkap',
                'sections' => [
                    ['type' => 'introduction', 'title' => 'Introduction', 'required' => true],
                    ['type' => 'basics', 'title' => 'The Basics', 'required' => true],
                    ['type' => 'advanced', 'title' => 'Advanced Topics', 'required' => false],
                    ['type' => 'examples', 'title' => 'Practical Examples', 'required' => true],
                    ['type' => 'resources', 'title' => 'Additional Resources', 'required' => false],
                ]
            ]
        ];
    }

    public function getTemplate(Request $request)
    {
        $templates = $this->getTemplates();
        $templateType = $request->get('type', 'tutorial');
        
        return response()->json($templates[$templateType] ?? $templates['tutorial']);
    }
}
