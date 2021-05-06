<?php

class TestController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		var_dump(__METHOD__);
	}

	public function actionThrow()
	{
		throw new Exception("Science");
	}

	public function actionDeleteOne() {
		$widgets = Widget::model()->findAll();
		$widget = array_shift($widgets);
		if($widget) {
			echo 'removing id=' . $widget->id;
			echo "\n<br>\n";
			$widget->delete();
		}
		var_dump(__METHOD__);
	}

	  public function actionLoadAndUpdate() {
    $widgets = Widget::model()->findAll();
    foreach($widgets as $widget) {
	    $widget->name = 'update widget';
	    echo "updating id=" . $widget->id;
	    echo "\n<br>\n";
	    $widget->save();
    }
  }
	  public function actionCreateNew() {
    $widget=new Widget;
    $widget->name='sample widget ' . time();
    $widget->content='post body content ' . time();
    $widget->save();
  }
	public function actionDatabase()
	{
        Yii::app()->db->active=true;
        $row=Yii::app()->db->createCommand('SELECT * FROM SomeTable')->query();
        print_r($row);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
