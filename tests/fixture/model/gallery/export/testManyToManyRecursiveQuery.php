<?php
return array(
	1 => array(
		'id' => '1',
		'name' => 'Foo Gallery',
		'active' => '1',
		'created' => '2007-06-20 21:02:27',
		'modified' => '2009-12-14 22:36:09',
		'images' => array(
			2 => array(
				'id' => '2',
				'gallery_id' => '1',
				'image' => 'image.jpg',
				'title' => 'Srinivasa Ramanujan',
				'created' => '2009-01-05 08:39:27',
				'modified' => '2009-03-14 05:42:07',
				'images_tags' => array(
					3 => array(
						'id' => '3',
						'image_id' => '2',
						'tag_id' => '5',
					),
				),
				'tags' => array(
					5 => array(
						'id' => '5',
						'name' => 'Science',
						'images_tags' => array(
							3 => array(
								'id' => '3',
								'image_id' => '2',
								'tag_id' => '5',
							),
						),
						'images' => array(
							2 => array(
								'id' => '2',
								'gallery_id' => '1',
								'image' => 'image.jpg',
								'title' => 'Srinivasa Ramanujan',
								'created' => '2009-01-05 08:39:27',
								'modified' => '2009-03-14 05:42:07',
								'images_tags' => array(
									3 => array(
										'id' => '3',
										'image_id' => '2',
										'tag_id' => '5',
									),
								),
								'tags' => array(
									5 => array(
										'id' => '5',
										'name' => 'Science',
									),
								),
							),
						),
					),
				),
			),
			3 => array(
				'id' => '3',
				'gallery_id' => '1',
				'image' => 'photo.jpg',
				'title' => 'Las Vegas',
				'created' => '2010-08-11 23:12:03',
				'modified' => '2010-09-24 04:45:14',
				'images_tags' => array(
					4 => array(
						'id' => '4',
						'image_id' => '3',
						'tag_id' => '6',
					),
				),
				'tags' => array(
					6 => array(
						'id' => '6',
						'name' => 'City',
						'images_tags' => array(
							4 => array(
								'id' => '4',
								'image_id' => '3',
								'tag_id' => '6',
							),
							5 => array(
								'id' => '5',
								'image_id' => '4',
								'tag_id' => '6',
							),
						),
						'images' => array(
							3 => array(
								'id' => '3',
								'gallery_id' => '1',
								'image' => 'photo.jpg',
								'title' => 'Las Vegas',
								'created' => '2010-08-11 23:12:03',
								'modified' => '2010-09-24 04:45:14',
								'images_tags' => array(
									4 => array(
										'id' => '4',
										'image_id' => '3',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
							4 => array(
								'id' => '4',
								'gallery_id' => '2',
								'image' => 'picture.jpg',
								'title' => 'Silicon Valley',
								'created' => '2008-08-22 17:55:10',
								'modified' => '2008-08-22 17:55:10',
								'images_tags' => array(
									7 => array(
										'id' => '7',
										'image_id' => '4',
										'tag_id' => '1',
									),
									6 => array(
										'id' => '6',
										'image_id' => '4',
										'tag_id' => '3',
									),
									5 => array(
										'id' => '5',
										'image_id' => '4',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
						),
					),
				),
			),
			1 => array(
				'id' => '1',
				'gallery_id' => '1',
				'image' => 'someimage.png',
				'title' => 'Amiga 1200',
				'created' => '2011-05-22 10:43:13',
				'modified' => '2012-11-30 18:38:10',
				'images_tags' => array(
					1 => array(
						'id' => '1',
						'image_id' => '1',
						'tag_id' => '1',
					),
					2 => array(
						'id' => '2',
						'image_id' => '1',
						'tag_id' => '3',
					),
				),
				'tags' => array(
					1 => array(
						'id' => '1',
						'name' => 'High Tech',
						'images_tags' => array(
							1 => array(
								'id' => '1',
								'image_id' => '1',
								'tag_id' => '1',
							),
							7 => array(
								'id' => '7',
								'image_id' => '4',
								'tag_id' => '1',
							),
						),
						'images' => array(
							1 => array(
								'id' => '1',
								'gallery_id' => '1',
								'image' => 'someimage.png',
								'title' => 'Amiga 1200',
								'created' => '2011-05-22 10:43:13',
								'modified' => '2012-11-30 18:38:10',
								'images_tags' => array(
									1 => array(
										'id' => '1',
										'image_id' => '1',
										'tag_id' => '1',
									),
									2 => array(
										'id' => '2',
										'image_id' => '1',
										'tag_id' => '3',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
								),
							),
							4 => array(
								'id' => '4',
								'gallery_id' => '2',
								'image' => 'picture.jpg',
								'title' => 'Silicon Valley',
								'created' => '2008-08-22 17:55:10',
								'modified' => '2008-08-22 17:55:10',
								'images_tags' => array(
									7 => array(
										'id' => '7',
										'image_id' => '4',
										'tag_id' => '1',
									),
									6 => array(
										'id' => '6',
										'image_id' => '4',
										'tag_id' => '3',
									),
									5 => array(
										'id' => '5',
										'image_id' => '4',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
						),
					),
					3 => array(
						'id' => '3',
						'name' => 'Computer',
						'images_tags' => array(
							2 => array(
								'id' => '2',
								'image_id' => '1',
								'tag_id' => '3',
							),
							6 => array(
								'id' => '6',
								'image_id' => '4',
								'tag_id' => '3',
							),
						),
						'images' => array(
							1 => array(
								'id' => '1',
								'gallery_id' => '1',
								'image' => 'someimage.png',
								'title' => 'Amiga 1200',
								'created' => '2011-05-22 10:43:13',
								'modified' => '2012-11-30 18:38:10',
								'images_tags' => array(
									1 => array(
										'id' => '1',
										'image_id' => '1',
										'tag_id' => '1',
									),
									2 => array(
										'id' => '2',
										'image_id' => '1',
										'tag_id' => '3',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
								),
							),
							4 => array(
								'id' => '4',
								'gallery_id' => '2',
								'image' => 'picture.jpg',
								'title' => 'Silicon Valley',
								'created' => '2008-08-22 17:55:10',
								'modified' => '2008-08-22 17:55:10',
								'images_tags' => array(
									7 => array(
										'id' => '7',
										'image_id' => '4',
										'tag_id' => '1',
									),
									6 => array(
										'id' => '6',
										'image_id' => '4',
										'tag_id' => '3',
									),
									5 => array(
										'id' => '5',
										'image_id' => '4',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
						),
					),
				),
			),
		),
	),
	2 => array(
		'id' => '2',
		'name' => 'Bar Gallery',
		'active' => '1',
		'created' => '2008-08-22 16:12:42',
		'modified' => '2008-08-22 16:12:42',
		'images' => array(
			4 => array(
				'id' => '4',
				'gallery_id' => '2',
				'image' => 'picture.jpg',
				'title' => 'Silicon Valley',
				'created' => '2008-08-22 17:55:10',
				'modified' => '2008-08-22 17:55:10',
				'images_tags' => array(
					7 => array(
						'id' => '7',
						'image_id' => '4',
						'tag_id' => '1',
					),
					6 => array(
						'id' => '6',
						'image_id' => '4',
						'tag_id' => '3',
					),
					5 => array(
						'id' => '5',
						'image_id' => '4',
						'tag_id' => '6',
					),
				),
				'tags' => array(
					1 => array(
						'id' => '1',
						'name' => 'High Tech',
						'images_tags' => array(
							1 => array(
								'id' => '1',
								'image_id' => '1',
								'tag_id' => '1',
							),
							7 => array(
								'id' => '7',
								'image_id' => '4',
								'tag_id' => '1',
							),
						),
						'images' => array(
							1 => array(
								'id' => '1',
								'gallery_id' => '1',
								'image' => 'someimage.png',
								'title' => 'Amiga 1200',
								'created' => '2011-05-22 10:43:13',
								'modified' => '2012-11-30 18:38:10',
								'images_tags' => array(
									1 => array(
										'id' => '1',
										'image_id' => '1',
										'tag_id' => '1',
									),
									2 => array(
										'id' => '2',
										'image_id' => '1',
										'tag_id' => '3',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
								),
							),
							4 => array(
								'id' => '4',
								'gallery_id' => '2',
								'image' => 'picture.jpg',
								'title' => 'Silicon Valley',
								'created' => '2008-08-22 17:55:10',
								'modified' => '2008-08-22 17:55:10',
								'images_tags' => array(
									7 => array(
										'id' => '7',
										'image_id' => '4',
										'tag_id' => '1',
									),
									6 => array(
										'id' => '6',
										'image_id' => '4',
										'tag_id' => '3',
									),
									5 => array(
										'id' => '5',
										'image_id' => '4',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
						),
					),
					3 => array(
						'id' => '3',
						'name' => 'Computer',
						'images_tags' => array(
							2 => array(
								'id' => '2',
								'image_id' => '1',
								'tag_id' => '3',
							),
							6 => array(
								'id' => '6',
								'image_id' => '4',
								'tag_id' => '3',
							),
						),
						'images' => array(
							1 => array(
								'id' => '1',
								'gallery_id' => '1',
								'image' => 'someimage.png',
								'title' => 'Amiga 1200',
								'created' => '2011-05-22 10:43:13',
								'modified' => '2012-11-30 18:38:10',
								'images_tags' => array(
									1 => array(
										'id' => '1',
										'image_id' => '1',
										'tag_id' => '1',
									),
									2 => array(
										'id' => '2',
										'image_id' => '1',
										'tag_id' => '3',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
								),
							),
							4 => array(
								'id' => '4',
								'gallery_id' => '2',
								'image' => 'picture.jpg',
								'title' => 'Silicon Valley',
								'created' => '2008-08-22 17:55:10',
								'modified' => '2008-08-22 17:55:10',
								'images_tags' => array(
									7 => array(
										'id' => '7',
										'image_id' => '4',
										'tag_id' => '1',
									),
									6 => array(
										'id' => '6',
										'image_id' => '4',
										'tag_id' => '3',
									),
									5 => array(
										'id' => '5',
										'image_id' => '4',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
						),
					),
					6 => array(
						'id' => '6',
						'name' => 'City',
						'images_tags' => array(
							4 => array(
								'id' => '4',
								'image_id' => '3',
								'tag_id' => '6',
							),
							5 => array(
								'id' => '5',
								'image_id' => '4',
								'tag_id' => '6',
							),
						),
						'images' => array(
							3 => array(
								'id' => '3',
								'gallery_id' => '1',
								'image' => 'photo.jpg',
								'title' => 'Las Vegas',
								'created' => '2010-08-11 23:12:03',
								'modified' => '2010-09-24 04:45:14',
								'images_tags' => array(
									4 => array(
										'id' => '4',
										'image_id' => '3',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
							4 => array(
								'id' => '4',
								'gallery_id' => '2',
								'image' => 'picture.jpg',
								'title' => 'Silicon Valley',
								'created' => '2008-08-22 17:55:10',
								'modified' => '2008-08-22 17:55:10',
								'images_tags' => array(
									7 => array(
										'id' => '7',
										'image_id' => '4',
										'tag_id' => '1',
									),
									6 => array(
										'id' => '6',
										'image_id' => '4',
										'tag_id' => '3',
									),
									5 => array(
										'id' => '5',
										'image_id' => '4',
										'tag_id' => '6',
									),
								),
								'tags' => array(
									1 => array(
										'id' => '1',
										'name' => 'High Tech',
									),
									3 => array(
										'id' => '3',
										'name' => 'Computer',
									),
									6 => array(
										'id' => '6',
										'name' => 'City',
									),
								),
							),
						),
					),
				),
			),
			5 => array(
				'id' => '5',
				'gallery_id' => '2',
				'image' => 'unknown.gif',
				'title' => 'Unknown',
				'created' => '2011-02-12 08:32:10',
				'modified' => '2012-04-16 14:18:52',
				'images_tags' => array(
				),
				'tags' => array(
				),
			),
		),
	),
);
?>