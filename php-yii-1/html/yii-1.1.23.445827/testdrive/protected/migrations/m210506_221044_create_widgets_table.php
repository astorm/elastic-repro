<?php

class m210506_221044_create_widgets_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('widgets', [
			'id'=>'pk',
			'name'=>'string NOT null',
			'content'=>'text'
		]);
	}

	public function down()
	{
		echo "m210506_221044_create_widgets_table does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
