!function(){"use strict";var t=wp.element,o=(wp.data,function(t){var o=t.attributes,n=t.clientId,e=o.layout,a=o.columnGap,c=o.rowGap,s=o.isContentEqualHight,l=o.sliderHeight,i=o.contentAlign,r=o.contentBG,d=o.contentPadding,p=o.border,u=o.sliderPageColor,b=o.sliderPageWidth,g=o.sliderPageHeight,P=o.sliderPageBorder,v=o.sliderPrevNextColor,f=o.isTitleLink,m=o.titleTypo,x=o.titleColor,y=o.titleMargin,h=o.metaTypo,w=o.metaTextColor,A=o.metaLinkColor,k=o.metaIconColor,M=o.metaColorsOnImage,S=o.metaMargin,C=o.excerptAlign,T=o.excerptTypo,I=o.excerptColor,L=o.excerptMargin,E=o.readMoreAlign,F=o.readMoreTypo,q=o.readMoreColors,z=o.readMoreHovColors,H=o.readMorePadding,G=o.readMoreBorder;return wp.element.createElement("style",{dangerouslySetInnerHTML:{__html:"\n\t\t".concat(null!=m&&m.googleFontLink?"@import url(".concat(null==m?void 0:m.googleFontLink,");"):"","\n\t\t").concat(null!=h&&h.googleFontLink?"@import url(".concat(null==h?void 0:h.googleFontLink,");"):"","\n\t\t").concat(null!=T&&T.googleFontLink?"@import url(".concat(null==T?void 0:T.googleFontLink,");"):"","\n\t\t").concat(null!=F&&F.googleFontLink?"@import url(".concat(null==F?void 0:F.googleFontLink,");"):"","\n\t\t\n\t\t#apbAdvancedPosts-").concat(n," .apbPost{\n\t\t\tmargin-bottom: ").concat("masonry"===e?"".concat(c,"px"):"0px",";\n\t\t\t").concat((null==p?void 0:p.styles)||"border: 1px solid #4527a400; border-radius: 5px;","\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbPostDefault, #apbAdvancedPosts-").concat(n," .apbPostSideImage{\n\t\t\ttext-align: ").concat(i,";\n\t\t\t").concat((null==r?void 0:r.styles)||"background-color: #f4f2fc;","\n\t\t}\n\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostText{ padding: ").concat((null==d?void 0:d.styles)||"20px 25px","; }\n\t\t#apbAdvancedPosts-").concat(n," .apbPostOverlay .apbPostText{\n\t\t\t").concat((null==r?void 0:r.styles)||"background-color: #f4f2fc;","\n\t\t\talign-items: ").concat("left"===i?"flex-start":"right"===i?"flex-end":"center"===i?"center":"","\n\t\t}\n\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostTitle{\n\t\t\ttext-align: ").concat(i,";\n\t\t\t").concat(f?"":(null==m?void 0:m.styles)||"font-family: Roboto, sans-serif; font-size: 25px;","\n\t\t\tcolor: ").concat(x,";\n\t\t\tmargin: ").concat((null==y?void 0:y.styles)||"0 0 15px 0",";\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostTitle a{\n\t\t\t").concat((null==m?void 0:m.styles)||"font-family: Roboto, sans-serif; font-size: 25px;","\n\t\t\tcolor: ").concat(x,";\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostMeta{\n\t\t\ttext-align: ").concat(i,";\n\t\t\t").concat((null==h?void 0:h.styles)||"font-size: 13px; text-transform: uppercase;","\n\t\t\tcolor: ").concat(w,";\n\t\t\tmargin: ").concat((null==S?void 0:S.styles)||"0 0 15px 0",";\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostMeta a{ color: ").concat(A,"; }\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostMeta .dashicons{ color: ").concat(k,"; }\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostFImgCats{ ").concat((null==h?void 0:h.styles)||"font-size: 13px; text-transform: uppercase;"," }\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostFImgCats a{ ").concat((null==M?void 0:M.styles)||"color: #fff; background: #4527a4;"," }\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostExcerpt{\n\t\t\ttext-align: ").concat(C,";\n\t\t\t").concat((null==T?void 0:T.styles)||"font-size: 15px;","\n\t\t\tcolor: ").concat(I,";\n\t\t\tmargin: ").concat((null==L?void 0:L.styles)||"0 0 10px 0",";\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostReadMore{ text-align: ").concat(E,"; }\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostReadMore a{\n\t\t\t").concat((null==F?void 0:F.styles)||"font-size: 14px; text-transform: uppercase; font-weight: 600;","\n\t\t\t").concat((null==q?void 0:q.styles)||"color: #fff; background: #8344c5;","\n\t\t\tpadding: ").concat((null==H?void 0:H.styles)||"12px 35px",";\n\t\t\t").concat((null==G?void 0:G.styles)||"border-radius: 3px;","\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbPost .apbPostReadMore a:hover{ ").concat((null==z?void 0:z.styles)||"color: #fff; background: #4527a4;"," }\n\n\t\t#apbAdvancedPosts-").concat(n," .apbGridPosts{\n\t\t\tgrid-gap: ").concat(c,"px ").concat(a,"px;\n\t\t\talign-items: ").concat(!1===s?"start":"initial",";\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbMasonryPosts{ gap: ").concat(a,"px; }\n\t\t#apbAdvancedPosts-").concat(n," .apbSliderPosts, #apbAdvancedPosts-").concat(n," .apbSliderPosts .swiper-slide{ min-height: ").concat(l,"; }\n\t\t#apbAdvancedPosts-").concat(n," .apbSliderPosts .swiper-pagination .swiper-pagination-bullet{\n\t\t\tbackground: ").concat(u,";\n\t\t\twidth: ").concat(b,";\n\t\t\theight: ").concat(g,";\n\t\t\t").concat((null==P?void 0:P.styles)||"border-radius: 50%;","\n\t\t}\n\t\t#apbAdvancedPosts-").concat(n," .apbSliderPosts .swiper-button-prev, #apbAdvancedPosts-").concat(n," .apbSliderPosts .swiper-button-next{ color: ").concat(v,"; }\n\t\t").replace(/\s+/g," ")}})}),n=jQuery;document.addEventListener("DOMContentLoaded",(function(){document.querySelectorAll(".wp-block-ap-block-posts").forEach((function(e){var a=JSON.parse(e.dataset.attributes),c=a.layout,s=a.columns,l=a.columnGap,i=a.rowGap,r=a.sliderIsLoop,d=a.sliderIsTouchMove,p=a.sliderIsAutoplay,u=a.sliderSpeed,b=a.sliderEffect,g=a.sliderIsPageClickable,P=a.sliderIsPageDynamic,v=document.querySelector("#".concat(e.id," .apbStyle"));(0,t.render)(wp.element.createElement(o,{attributes:a,clientId:a.cId}),v);var f=document.querySelector("#".concat(e.id," .apbSliderPosts"));f&&"slider"===c&&new Swiper(f,{direction:"horizontal",slidesPerView:null==s?void 0:s.mobile,breakpoints:{576:{slidesPerView:null==s?void 0:s.tablet},768:{slidesPerView:null==s?void 0:s.desktop}},spaceBetween:l,loop:r,allowTouchMove:d,grabCursor:d,autoplay:!!p&&{delay:1e3*u},speed:1e3*u,effect:b,fadeEffect:{crossFade:!0},creativeEffect:{prev:{shadow:!0,translate:["-120%",0,-500]},next:{shadow:!0,translate:["120%",0,-500]}},allowSlideNext:!0,allowSlidePrev:!0,autoHeight:!1,notificationClass:null,pagination:{el:".swiper-pagination",clickable:g,dynamicBullets:P},navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev"}});var m=[],x=document.querySelectorAll("#".concat(e.id," .apbSliderPosts .swiper-slide")),y=document.querySelectorAll("#".concat(e.id," .apbSliderPosts .swiper-slide .apbPostText"));(null==y?void 0:y.length)&&y.forEach((function(t){m.push(null==t?void 0:t.clientHeight)})),(null==x?void 0:x.length)&&x.forEach((function(t){t.style.height="".concat(Math.max.apply(Math,m),"px")}));var h=document.querySelector("#".concat(e.id," .apbTickerPosts"));h&&n(h).easyTicker({direction:"up",easing:"swing",speed:"slow",interval:2e3,height:"auto",visible:3,gap:i,mousePause:!0}),null==e||e.removeAttribute("data-attributes")}))}))}();
//# sourceMappingURL=script.js.map