.SuperCarousel, .SuperCarousel * {
	box-sizing: border-box;
	touch-action: none;
}

.SuperCarousel {
	position: relative;
	z-index: 0;
	overflow: hidden;
	--i: 0;
}

.SuperCarousel > .body {
	position: absolute;
	z-index: 100;
	width: 100%;
	height: 100%;
}

.SuperCarousel > .body > .item {
	position: absolute;
	width: 100%;
	height: 100%;
	padding: 14px 14px 18px;
	overflow: hidden;
	display: flex;
	justify-content: center;
	align-items: center;
	transition-property: right, left, bottom, top;
	transition-duration: var(--s, 1s);
}

.SuperCarousel > .body > .item.out {
	transition-duration: 0s;
}

.SuperCarousel[data-style="slide"] > .body > .item {
	--p: calc((var(--i) - var(--n)) * 100%);
}

.SuperCarousel[data-style="stackIn"] > .body > .item {
	z-index: calc(var(--n));
	--p: calc(min((var(--i) - var(--n)), 0) * 100%);
}

.SuperCarousel[data-style="stackOut"] > .body > .item {
	z-index: calc(0 - var(--n));
	--p: calc(max((var(--i) - var(--n)), 0) * 100%);
}

.SuperCarousel[data-direction="r2l"] > .body > .item {
	right: var(--p);
}

.SuperCarousel[data-direction="l2r"] > .body > .item {
	left: var(--p);
}

.SuperCarousel[data-direction="b2t"] > .body > .item {
	bottom: var(--p);
}

.SuperCarousel[data-direction="t2b"] > .body > .item {
	top: var(--p);
}

.SuperCarousel > .controller {
	position: absolute;
	bottom: 6px;
	z-index: 200;
	width: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	transition-duration: 0.2s;
}

.SuperCarousel > .controller.autoHide {
	opacity: 0;
}

.SuperCarousel:hover > .controller.autoHide {
	opacity: 1;
}

.SuperCarousel > .controller > .item {
	margin: 0 0.5em;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: rgb(255 165 0 / 30%);
	cursor: pointer;
	transition-duration: 0.2s;
}

.SuperCarousel > .controller > .item.active {
	background: rgb(255 165 0 / 60%);
}

.wkbreadcrumb +#siteNotice {
    margin-top: 10px;
}