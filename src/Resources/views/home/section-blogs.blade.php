
<section class="section-index section_blog">
	{{-- DEBUG: Hiển thị dữ liệu $latestBlogs --}}
	<pre style="background:#fff;color:#222;font-size:12px;max-width:100vw;overflow:auto;padding:8px 12px;border:1px solid #eee;">{{ var_export($latestBlogs, true) }}</pre>
	<div class="container">
		<div class="section-title-blog" data-aos="fade-right">
			<div class="sub_title">Tin tức mới nhất</div>
			<h2>
				<a href="{{ route('shop.article.index') }}" title="Xu Hướng Làm Đẹp &amp; Chăm Sóc Sức Khỏe">Xu Hướng Làm Đẹp &amp; Chăm Sóc Sức Khỏe</a>
			</h2>
		</div>
		<div class="desc" data-aos="fade-right">
			Mang đến cho bạn những thông tin mới nhất về xu hướng làm đẹp giúp bạn luôn khỏe đẹp từ bên trong.
		</div>

		<div class="beanspa-swiper" data-swiper="blogs" data-aos="fade-left">
			<div class="swiper-wrapper">
				{{-- BEANSPA BLOG UI: Render latest blogs dynamically --}}
				@foreach ($latestBlogs as $blog)
					@php
						$translation = $blog->translate(app()->getLocale());
						$title = $translation->name ?? $blog->name;
						$slug = $translation->slug ?? $blog->slug;
						$short = $translation->short_description ?? $blog->short_description;
						// Fallback ảnh nếu không có
						$img = $blog->src_url ?? $blog->src ?? asset('themes/beanspa/images/no-image.jpg');
						$author = $blog->author ?? 'Bean Spa';
						$url = route('shop.article.view', ['slug' => $slug, 'id' => $blog->id]);
					@endphp
					<div class="swiper-slide">
						<div class="item_blog">
							<a class="image-blog beanspa-blog-img" href="{{ $url }}" title="{{ $title }}">
								<img src="{{ $img }}" alt="{{ $title }}" class="lazy" loading="lazy">
								<span class="user_date">{{ optional($blog->published_at)->format('d/m/Y') }}</span>
							</a>
							<div class="blog_content">
								<h3><a href="{{ $url }}" title="{{ $title }}">{{ $title }}</a></h3>
								<p class="update_date clearfix">
									<span class="user_name">Đăng bởi: <b>{{ $author }}</b></span>
								</p>
								<div class="conten_info_blog">
									<p class="blog_description">{{ $short }}</p>
									<a class="read_more" href="{{ $url }}" title="Xem chi tiết">
										<span class="pbmit-button-text">Xem chi tiết</span>
										<svg class="pbmit-svg-arrow" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"><line x1="1" y1="18" x2="17.8" y2="1.2"></line><line x1="1.2" y1="1" x2="18" y2="1"></line><line x1="18" y1="17.8" x2="18" y2="1"></line></svg>
									</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			<div class="swiper-button-prev" data-swiper-prev>
				<svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M18.5 29H39.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
					<path d="M29 18.5L39.5 29L29 39.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
			</div>
			<div class="swiper-button-next" data-swiper-next>
				<svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M18.5 29H39.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
					<path d="M29 18.5L39.5 29L29 39.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
			</div>
		</div>
		<div class="box_see_blog" data-aos="zoom-in">
			<a href="{{ route('shop.article.index') }}" title="Xem tất cả" class="theme-btn btn-style-three exp-btn-title">
				<span class="btn-wrap">
					<span class="text-one">Xem tất cả <svg class="pbmit-svg-arrow" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"><line x1="1" y1="18" x2="17.8" y2="1.2"></line><line x1="1.2" y1="1" x2="18" y2="1"></line><line x1="18" y1="17.8" x2="18" y2="1"></line></svg></span>
					<span class="text-two">Xem tất cả <svg class="pbmit-svg-arrow" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"><line x1="1" y1="18" x2="17.8" y2="1.2"></line><line x1="1.2" y1="1" x2="18" y2="1"></line><line x1="18" y1="17.8" x2="18" y2="1"></line></svg></span>
				</span>
			</a>
		</div>
	</div>
</section>