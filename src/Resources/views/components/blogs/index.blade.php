

<section class="section-index section_blog">
	<div class="container max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
		<div class="section-title-blog" data-aos="fade-right">
			<div class="sub_title">Tin tức mới nhất</div>
			<h2>
				<a href="{{ route('shop.article.index') }}" title="Xu Hướng Làm Đẹp &amp; Chăm Sóc Sức Khỏe">Xu Hướng Làm Đẹp &amp; Chăm Sóc Sức Khỏe</a>
			</h2>
		</div>
		<div class="desc" data-aos="fade-right">
			Mang đến cho bạn những thông tin mới nhất về xu hướng làm đẹp giúp bạn luôn khỏe đẹp từ bên trong.
		</div>

		<!-- Swiper CSS (ensure only loaded once in layout or here for demo) -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
		  <div class="beanspa-swiper swiper-container swiper-initialized swiper-horizontal swiper-backface-hidden" data-swiper="blogs" data-feedback-ready="false" data-aos="fade-left">
			  <div class="swiper-wrapper" style="cursor: grab;">
				@foreach ($blogs as $i => $blog)
					@php
						$translation = $blog->translate(app()->getLocale());
						$title = $translation->name ?? $blog->name;
						$slug = $translation->slug ?? $blog->slug;
						$short = $translation->short_description ?? $blog->short_description;
						$img = (!empty($blog->src) && $blog->src !== 'undefined')
							? asset('storage/' . $blog->src)
							: asset('themes/beanspa/images/no-image.jpg');
						$author = $blog->author ?? 'Bean Spa';
						$url = route('shop.article.view', ['slug' => $slug, 'id' => $blog->id]);
					@endphp
					<div class="swiper-slide blog-slide" data-swiper-slide-index="{{ $i }}">
						<div class="item_blog" style="border:1px solid #eee; border-radius:16px; overflow:hidden; background:#fff; display:flex; flex-direction:column; height:100%;">
							<a class="image-blog beanspa-blog-img" href="{{ $url }}" title="{{ $title }}" style="display:block;">
								<img src="{{ $img }}" alt="{{ $title }}" style="width:100%; aspect-ratio:16/9; object-fit:cover;">
								<span class="user_date" style="position:absolute; top:12px; left:12px; background:#fff3; color:#222; font-size:0.95rem; padding:2px 10px; border-radius:8px;">{{ optional($blog->published_at)->format('d/m/Y') }}</span>
							</a>
							<div class="blog_content" style="padding:18px 16px 12px 16px; flex:1; display:flex; flex-direction:column;">
								<h3 style="text-base font-medium margin:0 0 8px 0;"><a href="{{ $url }}" title="{{ $title }}" style="color:#1b6060; text-decoration:none;">{{ $title }}</a></h3>
								<p class="update_date clearfix" style="margin:0 0 8px 0; color:#888; font-size:0.98rem;">
									<span class="user_name">Đăng bởi: <b>{{ $author }}</b></span>
								</p>
								<div class="conten_info_blog" style="flex:1;">
									<p class="blog_description text-sm" style="margin:0 0 12px 0; color:#444;">{{ $short }}</p>
									<a class="read_more" href="{{ $url }}" title="Xem chi tiết" style="color:#f0a793; font-weight:600; text-decoration:none;">
										<span class="pbmit-button-text">Xem chi tiết</span>
										<svg class="pbmit-svg-arrow" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"><line x1="1" y1="18" x2="17.8" y2="1.2"></line><line x1="1.2" y1="1" x2="18" y2="1"></line><line x1="18" y1="17.8" x2="18" y2="1"></line></svg>
									</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			   <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"></div>
			   <div class="swiper-button-prev" data-swiper-prev>
				   <svg class="swiper-navigation-icon" width="11" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.38296 20.0762C0.111788 19.805 0.111788 19.3654 0.38296 19.0942L9.19758 10.2796L0.38296 1.46497C0.111788 1.19379 0.111788 0.754138 0.38296 0.482966C0.654131 0.211794 1.09379 0.211794 1.36496 0.482966L10.4341 9.55214C10.8359 9.9539 10.8359 10.6053 10.4341 11.007L1.36496 20.0762C1.09379 20.3474 0.654131 20.3474 0.38296 20.0762Z" fill="currentColor"></path></svg>
			   </div>
			   <div class="swiper-button-next" data-swiper-next>
				   <svg class="swiper-navigation-icon" width="11" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.38296 20.0762C0.111788 19.805 0.111788 19.3654 0.38296 19.0942L9.19758 10.2796L0.38296 1.46497C0.111788 1.19379 0.111788 0.754138 0.38296 0.482966C0.654131 0.211794 1.09379 0.211794 1.36496 0.482966L10.4341 9.55214C10.8359 9.9539 10.8359 10.6053 10.4341 11.007L1.36496 20.0762C1.09379 20.3474 0.654131 20.3474 0.38296 20.0762Z" fill="currentColor"></path></svg>
			   </div>
		</div>
	

		<div class="box_see_blog" data-aos="zoom-in">
			<a href="{{ route('shop.article.index') }}" title="Xem tất cả" class="theme-btn btn-style-three exp-btn-title">
				<span class="btn-wrap">
					<span class="text-one">Xem tất cả <svg class="pbmit-svg-arrow" xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"><line x1="1" y1="18" x2="17.8" y2="1.2"></line><line x1="1.2" y1="1" x2="18" y2="1"></line><line x1="18" y1="17.8" x2="18" y2="1"></line></svg></span>
				</span>
			</a>
		</div>
        
	</div>
</section>

