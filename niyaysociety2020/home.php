<?php require($_SERVER['DOCUMENT_ROOT'] . '/blog/wp-load.php');  ?>
<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php');
?>

<section id="intro">
	<div class="container">
		<div class="search-box">
			<h1>ค้นหานิยายน่าอ่าน</h1>
			<div class="sub">แหล่งอ่านนิยายที่ทันสมัย อ่านง่าย สบายทุกอุปกรณ์</div>
			<div class="search-action">
				<? $a = new Area('Search'); $a->display($c); ?>
			</div>
			<ul>
				<li><a href="/write" class="btn-gradient2">สร้างผลงานใหม่</a></li>
				<li><a href="/drafts" class="btn-gradient2">เพิ่มเนื้อหา</a></li>
			</ul>
		</div>
	</div>
</section>
<!-- /#intro -->

<section id="sec-all" class="page-sec">
	<div class="container">
		<h2 class="page-title"><span>นิยายทั้งหมด</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-gradient2 is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php include('themes/niyaysociety2020/content/all.php'); ?>
		<div class="btn-more">
			<a href="/all-niyay/" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- /#sec-all -->

<section id="sec-drama" class="page-sec sec-inverse">
	<div class="container">
		<h2 class="page-title"><span>นิยายดราม่า</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-white is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Drama'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/drama" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-drama -->

<section id="sec-romantic" class="page-sec">
	<div class="container">
		<h2 class="page-title"><span>นิยายโรแมนติก</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-gradient2 is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Romantic'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/romantic" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-romantic -->

<section id="sec-romance" class="page-sec sec-inverse">
	<div class="container">
		<h2 class="page-title"><span>นิยายโรมานซ์</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-white is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Romance'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/erotic" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-romance -->

<section id="sec-y" class="page-sec">
	<div class="container">
		<h2 class="page-title"><span>นิยาย Y</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-gradient2 is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button id="btn-yuri" class="btn-gradient2 coming-soon" data-filter=".yuri">Yuri</button>
			<button id="btn-yaoi" class="btn-gradient2 coming-soon" data-filter=".yaoi">Yaoi</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Yuya'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/y" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-romantic -->

<section id="sec-fanfic" class="page-sec sec-inverse">
	<div class="container">
		<h2 class="page-title"><span>Fan Fic</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-white is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('FanFic'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/fanfic" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-fanfic -->

<section id="sec-fantasy" class="page-sec">
	<div class="container">
		<h2 class="page-title"><span>นิยายแฟนตาซี</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-gradient2 is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Fantasy'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/fantasy" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-romantic -->

<section id="sec-comedy" class="page-sec sec-inverse">
	<div class="container">
		<h2 class="page-title"><span>คอมเมดี้</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-white is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Comedy'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/comedy" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-comedy -->

<section id="sec-invest" class="page-sec">
	<div class="container">
		<h2 class="page-title"><span>นิยายสืบสวนสอบสวน</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-gradient2 is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Investigate'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/investigate" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-invest -->

<section id="sec-action" class="page-sec sec-inverse">
	<div class="container">
		<h2 class="page-title"><span>นิยายแอคชั่น</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-white is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-white" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Action'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/action" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>
<!-- #sec-action -->

<section id="sec-others" class="page-sec">
	<div class="container">
		<h2 class="page-title"><span>งานเขียนทั่วไป</span></h2>
		<div class="button-group filters-button-group">
			<button class="btn-gradient2 is-checked" data-sort-direction="desc" data-sort-value="date">อัพเดทล่าสุด</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="score">เรียงตามคะแนน</button>
			<button class="btn-gradient2" data-sort-direction="desc" data-sort-value="view">เรียงตามยอดวิว</button>
		</div>
		<?php $a = new Area('Other'); $a->display($c); ?>
		<div class="btn-more">
			<a href="/all-niyay/other" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>

<section id="topics" class="page-sec sec-inverse">
	<div class="container">
		<h2 class="page-title"><span>กระทู้</span></h2>
		<div class="topics">
			<div class="topic-item">
				<div class="topic-body">
					<a href="#" class="title-topics">
						<h3>ฝากผลงาน การ์ตูน ไว้สักนิดนึงครับ</h3>
						<ul>
							<li><span class="icon-read">135</span></li>
							<li><span class="icon-comments">2</span></li>
						</ul>
					</a>
				</div>
				<div class="topic-date">28 ตุลาคม 2016 เมื่อ 08:47 น.</div>
			</div>
		</div>
		<?php
			// $forum = new Area('Basic Forum');
			// $forum->display($c);
		?>
		<div class="btn-more">
			<a href="#" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>

<section id="blog" class="page-sec">
	<div class="container">
		<h2 class="page-title"><span>บทความ</span></h2>
		<div class="blog-list slider">
			<?php
			$args = array(
				'paged' => $paged,
				'post_type' => 'post',
				'order' => 'DESC',
				'orderby' => 'date',
				'posts_per_page' => 3
			);
			$wp_query = new WP_Query($args);
			while ($wp_query -> have_posts()): $wp_query -> the_post(); ?>
			<div class="blog-item">
				<a href="<?php echo get_permalink(); ?>" class="inner">
					<div class="cover-work">
					<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'blog-thumbnail', array('alt' => the_title_attribute( array('echo' => false,) ),) );
						} else {
						echo '<img src="/themes/niyaysociety2020/img/no_cover.jpg" alt="' . get_the_title() . '"/>';
					} ?></div>
					<div class="blog-content">
						<h3><?php the_title(); ?></h3>
						<div class="desc"><?php the_excerpt(); ?></div>
					</div>
				</a>
			</div>
			<?php endwhile; ?>
		</div>
		<div class="btn-more">
			<a href="//blog.niyaysociety.com" class="btn-gradient2">ดูทั้งหมด</a>
		</div>
	</div>
</section>

<?php $this->inc('elements/footer.php'); ?>
