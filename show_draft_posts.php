<?php
/*
 * Plugin Name: Show All Draft Posts And Pages
 * Description: Show draft posts and page is a plugin where you can see all your entire draft posts and pages and auto saveed posts through admin dashboard and also if you want you can show draft posts as a upcoming post in your website with just drag and drop widget.Also you can edit and delete Draft posts and pages easily
 * Version: 1.0.1
 * Author: Golam Dostogir
 * Author URI: http://www.savethemage.com/the-team
 * License: A "Slug" license name e.g. GPL2
 */
function helloworld(){
global $wpdb;

$query1 = $wpdb->get_results("
	select ID,post_title,post_author from $wpdb->posts where post_status='draft' order by ID desc limit 5
	");
foreach($query1 as $q)
{
	echo "<li>".$q->post_title."</li>";
}
}
function widget_draft($args)
{
	
	extract($args);
	echo $before_widget;
	echo $before_title;?>
	Upcoming Posts
	<?php
	echo $after_title;
	helloworld();
	echo $after_widget;
}

function my_draft_init()
{
	register_sidebar_widget(__('Draft as upcoming'),'widget_draft');
}
add_action("plugins_loaded","my_draft_init");

add_action('admin_menu','show_draft_post_menu');
function show_draft_post_menu()
{
	add_options_page('Show All Draft Posts','Show All Draft Posts','manage_options',__FILE__,'show_draft_posts');
}

function show_draft_posts()
{
?>
<div class="wrap">
<h4>All Draft posts,Pages,Auto Draft Posts:</h4>
<table class="widefat">
<thead>
<tr>
<th>Post Title</th>
<th>Post ID</th>
<th>Author</th>
<th>Action</th>
</tr>
</thead>
<tfoot>
<tr>
<th>Post Title</th>
<th>Post ID</th>
<th>Author</th>
<th>Action</th>
</tr>
</tfoot>
<tbody>
<?php
$id=$_GET['id'];
if($id=='11')
{
echo "ok";
}
?>
<?php
	global $wpdb;
	
	$post_query_result = $wpdb->get_results("
	select ID,post_title,post_author from $wpdb->posts where post_status='draft' || post_status='auto-draft' order by ID desc
	");
foreach($post_query_result as $results)
{
?>
<tr>
<td><a href="post.php?post=<?php echo $results->ID;?>&action=edit"><?php echo $results->post_title;?></a></td>
<td><?php echo $results->ID;?></td>
<td><?php echo the_author_meta( 'user_nicename' , $results->post_author ); ?> </td>
<td><a href="<?php echo get_delete_post_link($results->ID); ?> ">Delete</a> | <a href="post.php?post=<?php echo $results->ID;?>&action=edit">Edit</a></td>

</tr>

<?php }?>
</tbody>
<table>
</div>

<?php
}
?>