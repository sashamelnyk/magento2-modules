<?php
 
namespace Shurik\ChangePrice\Plugin;
 
class CustomBreadcrumbs
{
    public function beforeAddCrumb(\Magento\Theme\Block\Html\Breadcrumbs $subject, $crumbName, $crumbInfo)
    {
	/* Хочу спробувати пройти циклом по масиву crumbInfo і змінити потрібне значення */
	$crumbInfo['label'] = $crumbInfo['label'].'(!)';
	//$crumbInfo['title'] = $crumbInfo['title'].'(!)';
        return [$crumbName.'(!)', $crumbInfo];
    }
}
