import { Fragment, computed, createBlock, createCommentVNode, createSSRApp, createTextVNode, createVNode, h, mergeModels, mergeProps, nextTick, onBeforeUnmount, onMounted, onUnmounted, openBlock, ref, renderList, renderSlot, resolveDynamicComponent, toDisplayString, unref, useId, useModel, useSSRContext, vModelText, watch, withCtx, withDirectives, withModifiers } from "vue";
import { ssrIncludeBooleanAttr, ssrInterpolate, ssrLooseContain, ssrLooseEqual, ssrRenderAttr, ssrRenderAttrs, ssrRenderClass, ssrRenderComponent, ssrRenderDynamicModel, ssrRenderList, ssrRenderSlot, ssrRenderStyle, ssrRenderTeleport, ssrRenderVNode } from "vue/server-renderer";
import { ArrowLeft, ArrowRight, AtSign, BedDouble, Bell, Bold, BookOpen, Briefcase, Building2, Calendar, CalendarPlus, Camera, Check, ChevronDown, ChevronLeft, ChevronRight, CircleAlert, CircleCheck, Clock, Clock3, Compass, ExternalLink, Eye, EyeOff, Facebook, FileText, Globe, Hammer, Heading, Heart, Hourglass, Image, Inbox, Info, Instagram, Italic, Landmark, Leaf, Link2, List, Lock, LogIn, LogOut, Mail, Map as Map$1, MapPin, Maximize2, Megaphone, Menu, PenLine, PenTool, Pencil, Phone, Play, Plus, Quote, Save, Search, Send, Settings, Share2, SlidersHorizontal, Sparkles, Star, Store, Tag, Target, Ticket, Trash2, Trees, Upload, User, Users, UtensilsCrossed, Wrench, X, Youtube } from "lucide-vue-next";
import { Head, Link, createInertiaApp, router, useForm, usePage } from "@inertiajs/vue3";
import createServer from "@inertiajs/vue3/server";
import { renderToString } from "@vue/server-renderer";
import { createPinia, defineStore } from "pinia";
//#region \0rolldown/runtime.js
var __defProp = Object.defineProperty;
var __exportAll = (all, no_symbols) => {
	let target = {};
	for (var name in all) __defProp(target, name, {
		get: all[name],
		enumerable: true
	});
	if (!no_symbols) __defProp(target, Symbol.toStringTag, { value: "Module" });
	return target;
};
//#endregion
//#region resources/js/components/layout/AppContainer.vue
var _sfc_main$98 = {
	__name: "AppContainer",
	__ssrInlineRender: true,
	props: { as: {
		type: String,
		default: "div"
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			ssrRenderVNode(_push, createVNode(resolveDynamicComponent(__props.as), mergeProps({ class: "mx-auto w-full max-w-[var(--container-content)] px-4 md:px-6" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent, _scopeId);
					else return [renderSlot(_ctx.$slots, "default")];
				}),
				_: 3
			}), _parent);
		};
	}
};
var _sfc_setup$98 = _sfc_main$98.setup;
_sfc_main$98.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/AppContainer.vue");
	return _sfc_setup$98 ? _sfc_setup$98(props, ctx) : void 0;
};
//#endregion
//#region resources/js/constants/icons.js
var icons = {
	"arrow-right": ArrowRight,
	"arrow-left": ArrowLeft,
	search: Search,
	menu: Menu,
	x: X,
	tag: Tag,
	"map-pin": MapPin,
	calendar: Calendar,
	"calendar-plus": CalendarPlus,
	clock: Clock,
	"chevron-down": ChevronDown,
	"chevron-right": ChevronRight,
	"chevron-left": ChevronLeft,
	check: Check,
	"circle-check": CircleCheck,
	"circle-alert": CircleAlert,
	info: Info,
	sparkles: Sparkles,
	phone: Phone,
	mail: Mail,
	globe: Globe,
	facebook: Facebook,
	instagram: Instagram,
	youtube: Youtube,
	upload: Upload,
	filter: SlidersHorizontal,
	hourglass: Hourglass,
	zanat: Hammer,
	hrana: UtensilsCrossed,
	usluge: Wrench,
	priroda: Trees,
	kultura: Landmark,
	smjestaj: BedDouble,
	dogadjaj: Calendar,
	star: Star,
	inbox: Inbox,
	image: Image,
	"building-2": Building2,
	briefcase: Briefcase,
	"book-open": BookOpen,
	user: User,
	play: Play,
	maximize: Maximize2,
	ticket: Ticket,
	send: Send,
	map: Map$1,
	list: List,
	"external-link": ExternalLink,
	target: Target,
	users: Users,
	store: Store,
	pen: PenLine,
	heart: Heart,
	leaf: Leaf,
	camera: Camera,
	quote: Quote,
	share: Share2,
	compass: Compass,
	"file-text": FileText,
	megaphone: Megaphone,
	settings: Settings,
	pencil: Pencil,
	"trash-2": Trash2,
	bold: Bold,
	italic: Italic,
	heading: Heading,
	link: Link2,
	"log-in": LogIn,
	"log-out": LogOut,
	eye: Eye,
	"eye-off": EyeOff,
	lock: Lock,
	"at-sign": AtSign,
	bell: Bell,
	plus: Plus,
	"pen-tool": PenTool,
	"clock-3": Clock3,
	save: Save
};
//#endregion
//#region resources/js/components/base/BaseIcon.vue
var _sfc_main$97 = {
	__name: "BaseIcon",
	__ssrInlineRender: true,
	props: {
		name: {
			type: String,
			required: true
		},
		size: {
			type: [Number, String],
			default: 20
		}
	},
	setup(__props) {
		const props = __props;
		const component = computed(() => {
			return icons[props.name] || null;
		});
		return (_ctx, _push, _parent, _attrs) => {
			if (component.value) ssrRenderVNode(_push, createVNode(resolveDynamicComponent(component.value), mergeProps({
				size: Number(__props.size),
				"stroke-width": 1.75,
				"aria-hidden": "true"
			}, _attrs), null), _parent);
			else _push(`<!---->`);
		};
	}
};
var _sfc_setup$97 = _sfc_main$97.setup;
_sfc_main$97.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/base/BaseIcon.vue");
	return _sfc_setup$97 ? _sfc_setup$97(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/Hero.vue
var _sfc_main$96 = {
	__name: "Hero",
	__ssrInlineRender: true,
	props: {
		variant: {
			type: String,
			default: "slika-pozadina",
			validator: (v) => ["slika-pozadina", "split"].includes(v)
		},
		title: {
			type: String,
			default: ""
		},
		subtitle: {
			type: String,
			default: ""
		},
		image: {
			type: String,
			default: ""
		},
		kicker: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			if (__props.variant === "slika-pozadina") {
				_push(`<section${ssrRenderAttrs(mergeProps({ class: ["relative flex min-h-[360px] items-center overflow-hidden md:min-h-[460px]", !__props.image ? "bg-gradient-to-br from-primary to-primary-dark" : ""] }, _attrs))}>`);
				if (__props.image) _push(`<img${ssrRenderAttr("src", __props.image)}${ssrRenderAttr("alt", __props.title)} class="absolute inset-0 size-full object-cover">`);
				else _push(`<!---->`);
				_push(`<div class="absolute inset-0 bg-overlay"></div>`);
				_push(ssrRenderComponent(_sfc_main$98, { class: "relative py-16 md:py-20" }, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) {
							_push(`<div class="max-w-2xl"${_scopeId}>`);
							if (__props.kicker) _push(`<p class="mb-3 text-sm font-semibold uppercase tracking-wider text-secondary"${_scopeId}>${ssrInterpolate(__props.kicker)}</p>`);
							else _push(`<!---->`);
							_push(`<h1 class="font-heading text-4xl font-bold text-white md:text-5xl"${_scopeId}>${ssrInterpolate(__props.title)}</h1>`);
							if (__props.subtitle) _push(`<p class="mt-4 max-w-xl text-lg text-primary-tint"${_scopeId}>${ssrInterpolate(__props.subtitle)}</p>`);
							else _push(`<!---->`);
							if (_ctx.$slots.default) {
								_push(`<div class="mt-8 flex flex-wrap gap-3"${_scopeId}>`);
								ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent, _scopeId);
								_push(`</div>`);
							} else _push(`<!---->`);
							_push(`</div>`);
						} else return [createVNode("div", { class: "max-w-2xl" }, [
							__props.kicker ? (openBlock(), createBlock("p", {
								key: 0,
								class: "mb-3 text-sm font-semibold uppercase tracking-wider text-secondary"
							}, toDisplayString(__props.kicker), 1)) : createCommentVNode("", true),
							createVNode("h1", { class: "font-heading text-4xl font-bold text-white md:text-5xl" }, toDisplayString(__props.title), 1),
							__props.subtitle ? (openBlock(), createBlock("p", {
								key: 1,
								class: "mt-4 max-w-xl text-lg text-primary-tint"
							}, toDisplayString(__props.subtitle), 1)) : createCommentVNode("", true),
							_ctx.$slots.default ? (openBlock(), createBlock("div", {
								key: 2,
								class: "mt-8 flex flex-wrap gap-3"
							}, [renderSlot(_ctx.$slots, "default")])) : createCommentVNode("", true)
						])];
					}),
					_: 3
				}, _parent));
				_push(`</section>`);
			} else {
				_push(`<section${ssrRenderAttrs(mergeProps({ class: "bg-surface-alt" }, _attrs))}>`);
				_push(ssrRenderComponent(_sfc_main$98, null, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) {
							_push(`<div class="grid items-center gap-8 py-12 md:grid-cols-2 md:gap-12 md:py-16"${_scopeId}><div${_scopeId}>`);
							if (__props.kicker) _push(`<p class="mb-3 text-sm font-semibold uppercase tracking-wider text-accent-deep"${_scopeId}>${ssrInterpolate(__props.kicker)}</p>`);
							else _push(`<!---->`);
							_push(`<h1 class="font-heading text-4xl font-bold text-heading md:text-5xl"${_scopeId}>${ssrInterpolate(__props.title)}</h1>`);
							if (__props.subtitle) _push(`<p class="mt-4 text-lg text-text-muted"${_scopeId}>${ssrInterpolate(__props.subtitle)}</p>`);
							else _push(`<!---->`);
							if (_ctx.$slots.default) {
								_push(`<div class="mt-8 flex flex-wrap gap-3"${_scopeId}>`);
								ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent, _scopeId);
								_push(`</div>`);
							} else _push(`<!---->`);
							_push(`</div><div class="relative aspect-[4/3] overflow-hidden rounded-lg bg-primary-tint shadow-[var(--shadow-md)]"${_scopeId}>`);
							if (__props.image) _push(`<img${ssrRenderAttr("src", __props.image)}${ssrRenderAttr("alt", __props.title)} class="absolute inset-0 size-full object-cover"${_scopeId}>`);
							else {
								_push(`<span class="absolute inset-0 flex items-center justify-center text-primary"${_scopeId}>`);
								_push(ssrRenderComponent(_sfc_main$97, {
									name: "image",
									size: 48
								}, null, _parent, _scopeId));
								_push(`</span>`);
							}
							_push(`</div></div>`);
						} else return [createVNode("div", { class: "grid items-center gap-8 py-12 md:grid-cols-2 md:gap-12 md:py-16" }, [createVNode("div", null, [
							__props.kicker ? (openBlock(), createBlock("p", {
								key: 0,
								class: "mb-3 text-sm font-semibold uppercase tracking-wider text-accent-deep"
							}, toDisplayString(__props.kicker), 1)) : createCommentVNode("", true),
							createVNode("h1", { class: "font-heading text-4xl font-bold text-heading md:text-5xl" }, toDisplayString(__props.title), 1),
							__props.subtitle ? (openBlock(), createBlock("p", {
								key: 1,
								class: "mt-4 text-lg text-text-muted"
							}, toDisplayString(__props.subtitle), 1)) : createCommentVNode("", true),
							_ctx.$slots.default ? (openBlock(), createBlock("div", {
								key: 2,
								class: "mt-8 flex flex-wrap gap-3"
							}, [renderSlot(_ctx.$slots, "default")])) : createCommentVNode("", true)
						]), createVNode("div", { class: "relative aspect-[4/3] overflow-hidden rounded-lg bg-primary-tint shadow-[var(--shadow-md)]" }, [__props.image ? (openBlock(), createBlock("img", {
							key: 0,
							src: __props.image,
							alt: __props.title,
							class: "absolute inset-0 size-full object-cover"
						}, null, 8, ["src", "alt"])) : (openBlock(), createBlock("span", {
							key: 1,
							class: "absolute inset-0 flex items-center justify-center text-primary"
						}, [createVNode(_sfc_main$97, {
							name: "image",
							size: 48
						})]))])])];
					}),
					_: 3
				}, _parent));
				_push(`</section>`);
			}
		};
	}
};
var _sfc_setup$96 = _sfc_main$96.setup;
_sfc_main$96.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/Hero.vue");
	return _sfc_setup$96 ? _sfc_setup$96(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/Breadcrumb.vue
var _sfc_main$95 = {
	__name: "Breadcrumb",
	__ssrInlineRender: true,
	props: { items: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<nav${ssrRenderAttrs(mergeProps({
				"aria-label": "Putanja",
				class: "flex flex-wrap items-center gap-2 text-sm"
			}, _attrs))}><!--[-->`);
			ssrRenderList(__props.items, (it, i) => {
				_push(`<!--[-->`);
				if (it.to && i < __props.items.length - 1) _push(ssrRenderComponent(unref(Link), {
					href: it.to,
					class: "font-medium text-primary hover:underline"
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(`${ssrInterpolate(it.label)}`);
						else return [createTextVNode(toDisplayString(it.label), 1)];
					}),
					_: 2
				}, _parent));
				else _push(`<span class="font-semibold text-heading" aria-current="page">${ssrInterpolate(it.label)}</span>`);
				if (i < __props.items.length - 1) _push(`<span class="text-text-muted">/</span>`);
				else _push(`<!---->`);
				_push(`<!--]-->`);
			});
			_push(`<!--]--></nav>`);
		};
	}
};
var _sfc_setup$95 = _sfc_main$95.setup;
_sfc_main$95.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/Breadcrumb.vue");
	return _sfc_setup$95 ? _sfc_setup$95(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/CTASection.vue
var _sfc_main$94 = {
	__name: "CTASection",
	__ssrInlineRender: true,
	props: {
		title: {
			type: String,
			default: ""
		},
		text: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col items-center rounded-lg bg-primary px-8 py-12 text-center" }, _attrs))}><h2 class="font-heading text-3xl font-bold text-white md:text-4xl">${ssrInterpolate(__props.title)}</h2>`);
			if (__props.text) _push(`<p class="mt-3 max-w-2xl text-lg text-primary-tint">${ssrInterpolate(__props.text)}</p>`);
			else _push(`<!---->`);
			if (_ctx.$slots.default) {
				_push(`<div class="mt-8 flex flex-wrap justify-center gap-3">`);
				ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
				_push(`</div>`);
			} else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$94 = _sfc_main$94.setup;
_sfc_main$94.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/CTASection.vue");
	return _sfc_setup$94 ? _sfc_setup$94(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/base/BaseButton.vue
var _sfc_main$93 = {
	__name: "BaseButton",
	__ssrInlineRender: true,
	props: {
		variant: {
			type: String,
			default: "primary",
			validator: (v) => [
				"primary",
				"secondary",
				"ghost",
				"akcent",
				"sekundarna"
			].includes(v)
		},
		size: {
			type: String,
			default: "md",
			validator: (v) => ["md", "sm"].includes(v)
		},
		icon: {
			type: String,
			default: ""
		},
		iconPosition: {
			type: String,
			default: "left"
		},
		disabled: {
			type: Boolean,
			default: false
		},
		to: {
			type: [String, Object],
			default: null
		},
		href: {
			type: String,
			default: null
		},
		type: {
			type: String,
			default: "button"
		},
		block: {
			type: Boolean,
			default: false
		}
	},
	setup(__props) {
		const props = __props;
		const variants = {
			primary: "bg-primary text-white hover:bg-primary-dark",
			secondary: "bg-surface text-primary border border-primary hover:bg-primary-tint",
			ghost: "bg-transparent text-primary hover:bg-primary-tint",
			akcent: "bg-accent text-heading hover:bg-accent-dark",
			sekundarna: "bg-secondary text-heading hover:bg-secondary-dark"
		};
		const sizes = {
			md: "h-11 px-5 text-base",
			sm: "h-9 px-4 text-sm"
		};
		const classes = computed(() => [
			"inline-flex items-center justify-center gap-2 rounded-sm font-semibold transition-colors",
			"disabled:cursor-not-allowed disabled:opacity-50",
			variants[props.variant],
			sizes[props.size],
			props.block ? "w-full" : ""
		]);
		const tag = computed(() => {
			if (props.to) return Link;
			if (props.href) return "a";
			return "button";
		});
		const iconSize = computed(() => props.size === "sm" ? 16 : 18);
		return (_ctx, _push, _parent, _attrs) => {
			ssrRenderVNode(_push, createVNode(resolveDynamicComponent(tag.value), mergeProps({
				href: (tag.value === unref(Link) ? __props.to : __props.href) || void 0,
				type: tag.value === "button" ? __props.type : void 0,
				disabled: tag.value === "button" ? __props.disabled : void 0,
				"aria-disabled": tag.value !== "button" && __props.disabled ? "true" : void 0,
				class: classes.value
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						if (__props.icon && __props.iconPosition === "left") _push(ssrRenderComponent(_sfc_main$97, {
							name: __props.icon,
							size: iconSize.value
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<span${_scopeId}>`);
						ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent, _scopeId);
						_push(`</span>`);
						if (__props.icon && __props.iconPosition === "right") _push(ssrRenderComponent(_sfc_main$97, {
							name: __props.icon,
							size: iconSize.value
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
					} else return [
						__props.icon && __props.iconPosition === "left" ? (openBlock(), createBlock(_sfc_main$97, {
							key: 0,
							name: __props.icon,
							size: iconSize.value
						}, null, 8, ["name", "size"])) : createCommentVNode("", true),
						createVNode("span", null, [renderSlot(_ctx.$slots, "default")]),
						__props.icon && __props.iconPosition === "right" ? (openBlock(), createBlock(_sfc_main$97, {
							key: 1,
							name: __props.icon,
							size: iconSize.value
						}, null, 8, ["name", "size"])) : createCommentVNode("", true)
					];
				}),
				_: 3
			}), _parent);
		};
	}
};
var _sfc_setup$93 = _sfc_main$93.setup;
_sfc_main$93.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/base/BaseButton.vue");
	return _sfc_setup$93 ? _sfc_setup$93(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/About.vue
var About_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$92 });
var _sfc_main$92 = {
	__name: "About",
	__ssrInlineRender: true,
	setup(__props) {
		const ciljevi = [
			{
				icon: "store",
				title: "Promocija lokalne ponude",
				text: "Vidljivost domaćih proizvoda, usluga i atrakcija Teslića na jednom mjestu."
			},
			{
				icon: "sparkles",
				title: "Vidljivost biznisa",
				text: "Mali proizvođači i obrti dobijaju moderan profil i dolaze do posjetilaca."
			},
			{
				icon: "book-open",
				title: "Autentične priče",
				text: "Priče domaćina, zanatlija i autora koje oslikavaju duh kraja."
			},
			{
				icon: "user",
				title: "Profili subjekata",
				text: "Detaljni profili biznisa i lokaliteta s kontaktima, galerijom i mapom."
			},
			{
				icon: "map",
				title: "Interaktivna mapa",
				text: "Pregled cjelokupne ponude na mapi — brzo pronalaženje sadržaja u blizini."
			},
			{
				icon: "compass",
				title: "Samostalno upravljanje",
				text: "Subjekti samostalno objavljuju i ažuriraju svoje sadržaje uz pregled administratora."
			}
		];
		const publika = [
			{
				icon: "users",
				title: "Posjetioci",
				text: "Istražite prirodu, smještaj, događaje i domaću ponudu Teslića na jednom mjestu.",
				cta: "Istraži ponudu",
				to: "/turizam"
			},
			{
				icon: "store",
				title: "Biznisi",
				text: "Predstavite svoj proizvod ili uslugu i dođite do novih kupaca i gostiju.",
				cta: "Registruj biznis",
				to: "/pridruzi-se/biznis"
			},
			{
				icon: "pen",
				title: "Autori",
				text: "Pišite priče o ljudima, mjestima i tradiciji kraja i podijelite ih sa svijetom.",
				cta: "Postani autor",
				to: "/pridruzi-se/autor"
			}
		];
		const partneri = [
			"Turistička organizacija Teslić",
			"Opština Teslić",
			"Banja Vrućica",
			"Lokalni proizvođači"
		];
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$96, {
				variant: "split",
				kicker: "O projektu",
				title: "Platforma turističke ponude Teslića",
				subtitle: "Jedinstveno mjesto koje povezuje posjetioce, lokalne biznise i autore — i predstavlja sve što Teslić nudi."
			}, null, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "O projektu" }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "O projektu" }] })];
				}),
				_: 1
			}, _parent));
			_push(`<section class="py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, null, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(`<div class="max-w-3xl"${_scopeId}><h2 class="font-heading text-2xl font-bold text-heading md:text-3xl"${_scopeId}>Misija i svrha</h2><p class="mt-4 text-lg text-text-muted"${_scopeId}> Cilj platforme je da na modernom i preglednom mjestu objedini turističku i privrednu ponudu Teslića. Želimo da posjetioci lako pronađu prirodu, smještaj, događaje i domaće proizvode, a da lokalni domaćini i biznisi dobiju vidljivost koju zaslužuju. </p><p class="mt-4 text-lg text-text-muted"${_scopeId}> Posebnu pažnju posvećujemo autentičnim pričama kraja — ljudima, zanatima i tradiciji koji čine Teslić prepoznatljivim. </p></div>`);
					else return [createVNode("div", { class: "max-w-3xl" }, [
						createVNode("h2", { class: "font-heading text-2xl font-bold text-heading md:text-3xl" }, "Misija i svrha"),
						createVNode("p", { class: "mt-4 text-lg text-text-muted" }, " Cilj platforme je da na modernom i preglednom mjestu objedini turističku i privrednu ponudu Teslića. Želimo da posjetioci lako pronađu prirodu, smještaj, događaje i domaće proizvode, a da lokalni domaćini i biznisi dobiju vidljivost koju zaslužuju. "),
						createVNode("p", { class: "mt-4 text-lg text-text-muted" }, " Posebnu pažnju posvećujemo autentičnim pričama kraja — ljudima, zanatima i tradiciji koji čine Teslić prepoznatljivim. ")
					])];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface-alt py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, null, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<h2 class="font-heading text-2xl font-bold text-heading md:text-3xl"${_scopeId}>Ciljevi projekta</h2><div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"${_scopeId}><!--[-->`);
						ssrRenderList(ciljevi, (cilj) => {
							_push(`<div class="rounded-md border border-border bg-surface p-6 shadow-[var(--shadow-sm)]"${_scopeId}><span class="flex size-12 items-center justify-center rounded-md bg-primary-tint text-primary"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: cilj.icon,
								size: 24
							}, null, _parent, _scopeId));
							_push(`</span><h3 class="mt-4 text-lg font-semibold text-heading"${_scopeId}>${ssrInterpolate(cilj.title)}</h3><p class="mt-2 text-sm text-text-muted"${_scopeId}>${ssrInterpolate(cilj.text)}</p></div>`);
						});
						_push(`<!--]--></div>`);
					} else return [createVNode("h2", { class: "font-heading text-2xl font-bold text-heading md:text-3xl" }, "Ciljevi projekta"), createVNode("div", { class: "mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" }, [(openBlock(), createBlock(Fragment, null, renderList(ciljevi, (cilj) => {
						return createVNode("div", {
							key: cilj.title,
							class: "rounded-md border border-border bg-surface p-6 shadow-[var(--shadow-sm)]"
						}, [
							createVNode("span", { class: "flex size-12 items-center justify-center rounded-md bg-primary-tint text-primary" }, [createVNode(_sfc_main$97, {
								name: cilj.icon,
								size: 24
							}, null, 8, ["name"])]),
							createVNode("h3", { class: "mt-4 text-lg font-semibold text-heading" }, toDisplayString(cilj.title), 1),
							createVNode("p", { class: "mt-2 text-sm text-text-muted" }, toDisplayString(cilj.text), 1)
						]);
					}), 64))])];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, null, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<h2 class="font-heading text-2xl font-bold text-heading md:text-3xl"${_scopeId}> Kome je namijenjena </h2><div class="mt-8 grid gap-6 md:grid-cols-3"${_scopeId}><!--[-->`);
						ssrRenderList(publika, (grupa) => {
							_push(`<div class="flex flex-col rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]"${_scopeId}><span class="flex size-14 items-center justify-center rounded-full bg-primary text-white"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: grupa.icon,
								size: 26
							}, null, _parent, _scopeId));
							_push(`</span><h3 class="mt-4 text-xl font-semibold text-heading"${_scopeId}>${ssrInterpolate(grupa.title)}</h3><p class="mt-2 flex-1 text-text-muted"${_scopeId}>${ssrInterpolate(grupa.text)}</p>`);
							_push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								icon: "arrow-right",
								"icon-position": "right",
								to: grupa.to,
								class: "mt-5 self-start"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(grupa.cta)}`);
									else return [createTextVNode(toDisplayString(grupa.cta), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
							_push(`</div>`);
						});
						_push(`<!--]--></div>`);
					} else return [createVNode("h2", { class: "font-heading text-2xl font-bold text-heading md:text-3xl" }, " Kome je namijenjena "), createVNode("div", { class: "mt-8 grid gap-6 md:grid-cols-3" }, [(openBlock(), createBlock(Fragment, null, renderList(publika, (grupa) => {
						return createVNode("div", {
							key: grupa.title,
							class: "flex flex-col rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]"
						}, [
							createVNode("span", { class: "flex size-14 items-center justify-center rounded-full bg-primary text-white" }, [createVNode(_sfc_main$97, {
								name: grupa.icon,
								size: 26
							}, null, 8, ["name"])]),
							createVNode("h3", { class: "mt-4 text-xl font-semibold text-heading" }, toDisplayString(grupa.title), 1),
							createVNode("p", { class: "mt-2 flex-1 text-text-muted" }, toDisplayString(grupa.text), 1),
							createVNode(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								icon: "arrow-right",
								"icon-position": "right",
								to: grupa.to,
								class: "mt-5 self-start"
							}, {
								default: withCtx(() => [createTextVNode(toDisplayString(grupa.cta), 1)]),
								_: 2
							}, 1032, ["to"])
						]);
					}), 64))])];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface-alt py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, null, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<h2 class="font-heading text-2xl font-bold text-heading md:text-3xl"${_scopeId}>Nosilac i partneri</h2><p class="mt-4 max-w-3xl text-text-muted"${_scopeId}> Platformu vodi Turistička organizacija Teslić u saradnji s lokalnom zajednicom, proizvođačima i institucijama koje podržavaju razvoj turizma kraja. </p><div class="mt-8 flex flex-wrap gap-4"${_scopeId}><!--[-->`);
						ssrRenderList(partneri, (p) => {
							_push(`<div class="flex h-20 min-w-[180px] flex-1 items-center justify-center rounded-md border border-border bg-surface px-6 text-center text-sm font-semibold text-text-muted"${_scopeId}>${ssrInterpolate(p)}</div>`);
						});
						_push(`<!--]--></div>`);
					} else return [
						createVNode("h2", { class: "font-heading text-2xl font-bold text-heading md:text-3xl" }, "Nosilac i partneri"),
						createVNode("p", { class: "mt-4 max-w-3xl text-text-muted" }, " Platformu vodi Turistička organizacija Teslić u saradnji s lokalnom zajednicom, proizvođačima i institucijama koje podržavaju razvoj turizma kraja. "),
						createVNode("div", { class: "mt-8 flex flex-wrap gap-4" }, [(openBlock(), createBlock(Fragment, null, renderList(partneri, (p) => {
							return createVNode("div", {
								key: p,
								class: "flex h-20 min-w-[180px] flex-1 items-center justify-center rounded-md border border-border bg-surface px-6 text-center text-sm font-semibold text-text-muted"
							}, toDisplayString(p), 1);
						}), 64))])
					];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, null, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$94, {
						title: "Pridružite se platformi",
						text: "Predstavite svoj biznis ili podijelite priču iz Teslića."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "sekundarna",
								to: "/pridruzi-se"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`Pridruži se`);
									else return [createTextVNode("Pridruži se")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "sekundarna",
								to: "/pridruzi-se"
							}, {
								default: withCtx(() => [createTextVNode("Pridruži se")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$94, {
						title: "Pridružite se platformi",
						text: "Predstavite svoj biznis ili podijelite priču iz Teslića."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "sekundarna",
							to: "/pridruzi-se"
						}, {
							default: withCtx(() => [createTextVNode("Pridruži se")]),
							_: 1
						})]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			_push(`</section></main>`);
		};
	}
};
var _sfc_setup$92 = _sfc_main$92.setup;
_sfc_main$92.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/About.vue");
	return _sfc_setup$92 ? _sfc_setup$92(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/InfoPanel.vue
var _sfc_main$91 = {
	__name: "InfoPanel",
	__ssrInlineRender: true,
	props: {
		title: {
			type: String,
			default: ""
		},
		items: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const isInternal = (href) => typeof href === "string" && href.startsWith("/");
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<aside${ssrRenderAttrs(mergeProps({ class: "rounded-md border border-border bg-surface p-5 shadow-[var(--shadow-sm)] md:p-6" }, _attrs))}>`);
			if (__props.title) _push(`<h2 class="mb-4 font-heading text-lg font-semibold text-heading">${ssrInterpolate(__props.title)}</h2>`);
			else _push(`<!---->`);
			_push(`<ul class="flex flex-col gap-4"><!--[-->`);
			ssrRenderList(__props.items, (item, i) => {
				_push(`<li class="flex items-start gap-3"><span class="mt-0.5 shrink-0 text-primary">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: item.icon,
					size: 20
				}, null, _parent));
				_push(`</span><div class="min-w-0"><p class="text-xs uppercase tracking-wide text-text-muted">${ssrInterpolate(item.label)}</p>`);
				if (item.href && isInternal(item.href)) _push(ssrRenderComponent(unref(Link), {
					href: item.href,
					class: "break-words font-medium text-primary hover:underline"
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(`${ssrInterpolate(item.value)}`);
						else return [createTextVNode(toDisplayString(item.value), 1)];
					}),
					_: 2
				}, _parent));
				else if (item.href) _push(`<a${ssrRenderAttr("href", item.href)} class="break-words font-medium text-primary hover:underline">${ssrInterpolate(item.value)}</a>`);
				else _push(`<p class="break-words text-text">${ssrInterpolate(item.value)}</p>`);
				_push(`</div></li>`);
			});
			_push(`<!--]--></ul>`);
			if (_ctx.$slots.default) {
				_push(`<div class="mt-5 border-t border-border pt-5">`);
				ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
				_push(`</div>`);
			} else _push(`<!---->`);
			_push(`</aside>`);
		};
	}
};
var _sfc_setup$91 = _sfc_main$91.setup;
_sfc_main$91.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/InfoPanel.vue");
	return _sfc_setup$91 ? _sfc_setup$91(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/layout/CardGrid.vue
var _sfc_main$90 = {
	__name: "CardGrid",
	__ssrInlineRender: true,
	props: { cols: {
		type: Number,
		default: 4
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: ["grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6", __props.cols === 3 ? "lg:grid-cols-3" : "lg:grid-cols-4"] }, _attrs))}>`);
			ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$90 = _sfc_main$90.setup;
_sfc_main$90.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/CardGrid.vue");
	return _sfc_setup$90 ? _sfc_setup$90(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/RelatedContent.vue
var _sfc_main$89 = {
	__name: "RelatedContent",
	__ssrInlineRender: true,
	props: {
		title: {
			type: String,
			default: "Povezano"
		},
		cols: {
			type: Number,
			default: 3
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<section${ssrRenderAttrs(mergeProps({ class: "mt-12" }, _attrs))}><h2 class="mb-6 font-heading text-2xl font-bold text-heading">${ssrInterpolate(__props.title)}</h2>`);
			_push(ssrRenderComponent(_sfc_main$90, { cols: __props.cols }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent, _scopeId);
					else return [renderSlot(_ctx.$slots, "default")];
				}),
				_: 3
			}, _parent));
			_push(`</section>`);
		};
	}
};
var _sfc_setup$89 = _sfc_main$89.setup;
_sfc_main$89.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/RelatedContent.vue");
	return _sfc_setup$89 ? _sfc_setup$89(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/base/BaseChip.vue
var base = "inline-flex items-center gap-1.5 rounded-pill font-medium transition-colors";
var _sfc_main$88 = {
	__name: "BaseChip",
	__ssrInlineRender: true,
	props: {
		variant: {
			type: String,
			default: "kategorija",
			validator: (v) => [
				"filter",
				"kategorija",
				"uklonjiv"
			].includes(v)
		},
		label: {
			type: String,
			required: true
		},
		icon: {
			type: String,
			default: ""
		},
		active: {
			type: Boolean,
			default: false
		}
	},
	emits: ["click", "remove"],
	setup(__props) {
		const props = __props;
		const classes = computed(() => {
			if (props.variant === "filter") return [
				base,
				"px-4 py-2 text-sm cursor-pointer",
				props.active ? "bg-primary text-white" : "bg-primary-tint text-primary-dark hover:bg-primary-tint-2"
			];
			if (props.variant === "uklonjiv") return [base, "px-4 py-2 text-sm bg-primary-tint text-primary-dark"];
			return [base, "px-3 py-1.5 text-[13px] bg-surface text-text border border-border"];
		});
		return (_ctx, _push, _parent, _attrs) => {
			ssrRenderVNode(_push, createVNode(resolveDynamicComponent(__props.variant === "filter" ? "button" : "span"), mergeProps({
				type: __props.variant === "filter" ? "button" : void 0,
				"aria-pressed": __props.variant === "filter" ? String(__props.active) : void 0,
				class: classes.value,
				onClick: ($event) => __props.variant === "filter" && _ctx.$emit("click")
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						if (__props.icon) _push(ssrRenderComponent(_sfc_main$97, {
							name: __props.icon,
							size: 14
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<span${_scopeId}>${ssrInterpolate(__props.label)}</span>`);
						if (__props.variant === "uklonjiv") {
							_push(`<button type="button" class="-mr-1 ml-0.5 inline-flex cursor-pointer rounded-full p-0.5 hover:bg-primary-tint-2"${ssrRenderAttr("aria-label", `Ukloni ${__props.label}`)}${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: "x",
								size: 14
							}, null, _parent, _scopeId));
							_push(`</button>`);
						} else _push(`<!---->`);
					} else return [
						__props.icon ? (openBlock(), createBlock(_sfc_main$97, {
							key: 0,
							name: __props.icon,
							size: 14
						}, null, 8, ["name"])) : createCommentVNode("", true),
						createVNode("span", null, toDisplayString(__props.label), 1),
						__props.variant === "uklonjiv" ? (openBlock(), createBlock("button", {
							key: 1,
							type: "button",
							class: "-mr-1 ml-0.5 inline-flex cursor-pointer rounded-full p-0.5 hover:bg-primary-tint-2",
							"aria-label": `Ukloni ${__props.label}`,
							onClick: ($event) => _ctx.$emit("remove")
						}, [createVNode(_sfc_main$97, {
							name: "x",
							size: 14
						})], 8, ["aria-label", "onClick"])) : createCommentVNode("", true)
					];
				}),
				_: 1
			}), _parent);
		};
	}
};
var _sfc_setup$88 = _sfc_main$88.setup;
_sfc_main$88.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/base/BaseChip.vue");
	return _sfc_setup$88 ? _sfc_setup$88(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/base/BaseBadge.vue
var _sfc_main$87 = {
	__name: "BaseBadge",
	__ssrInlineRender: true,
	props: {
		variant: {
			type: String,
			default: "objavljeno",
			validator: (v) => [
				"objavljeno",
				"na-odobrenju",
				"nacrt",
				"isteklo",
				"odbijeno",
				"preporuceno",
				"zavrseno"
			].includes(v)
		},
		label: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		const props = __props;
		const map = {
			objavljeno: {
				bg: "bg-success-tint",
				text: "text-success",
				dot: "bg-success",
				def: "Objavljeno"
			},
			"na-odobrenju": {
				bg: "bg-warning-tint",
				text: "text-warning",
				dot: "bg-warning",
				def: "Na odobrenju"
			},
			nacrt: {
				bg: "bg-neutral-tint",
				text: "text-neutral-badge",
				dot: "bg-neutral-badge",
				def: "Nacrt"
			},
			isteklo: {
				bg: "bg-neutral-tint",
				text: "text-neutral-badge",
				dot: "bg-neutral-badge",
				def: "Isteklo"
			},
			zavrseno: {
				bg: "bg-neutral-tint",
				text: "text-neutral-badge",
				dot: "bg-neutral-badge",
				def: "Završeno"
			},
			odbijeno: {
				bg: "bg-error-tint",
				text: "text-error",
				dot: "bg-error",
				def: "Odbijeno"
			},
			preporuceno: {
				bg: "bg-accent-tint",
				text: "text-accent-deep",
				dot: "bg-accent",
				def: "Preporučeno"
			}
		};
		const style = computed(() => map[props.variant]);
		const text = computed(() => props.label || style.value.def);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<span${ssrRenderAttrs(mergeProps({ class: ["inline-flex items-center gap-1.5 rounded-pill px-3 py-1 text-xs font-semibold", [style.value.bg, style.value.text]] }, _attrs))}><span class="${ssrRenderClass([style.value.dot, "size-1.5 rounded-full"])}"></span> ${ssrInterpolate(text.value)}</span>`);
		};
	}
};
var _sfc_setup$87 = _sfc_main$87.setup;
_sfc_main$87.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/base/BaseBadge.vue");
	return _sfc_setup$87 ? _sfc_setup$87(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/base/BaseAlert.vue
var _sfc_main$86 = {
	__name: "BaseAlert",
	__ssrInlineRender: true,
	props: {
		variant: {
			type: String,
			default: "info",
			validator: (v) => [
				"uspjeh",
				"greska",
				"info"
			].includes(v)
		},
		title: {
			type: String,
			default: ""
		},
		text: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		const props = __props;
		const map = {
			uspjeh: {
				bg: "bg-success-tint",
				text: "text-success",
				icon: "circle-check"
			},
			greska: {
				bg: "bg-error-tint",
				text: "text-error",
				icon: "circle-alert"
			},
			info: {
				bg: "bg-info-tint",
				text: "text-info",
				icon: "info"
			}
		};
		const style = computed(() => map[props.variant]);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({
				class: ["flex gap-3 rounded-md p-4", style.value.bg],
				role: "alert"
			}, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: style.value.icon,
				size: 20,
				class: [style.value.text, "mt-0.5 shrink-0"]
			}, null, _parent));
			_push(`<div class="space-y-0.5">`);
			if (__props.title) _push(`<p class="${ssrRenderClass([style.value.text, "font-semibold"])}">${ssrInterpolate(__props.title)}</p>`);
			else _push(`<!---->`);
			if (__props.text || _ctx.$slots.default) {
				_push(`<p class="text-sm text-text">`);
				ssrRenderSlot(_ctx.$slots, "default", {}, () => {
					_push(`${ssrInterpolate(__props.text)}`);
				}, _push, _parent);
				_push(`</p>`);
			} else _push(`<!---->`);
			_push(`</div></div>`);
		};
	}
};
var _sfc_setup$86 = _sfc_main$86.setup;
_sfc_main$86.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/base/BaseAlert.vue");
	return _sfc_setup$86 ? _sfc_setup$86(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/EmptyState.vue
var _sfc_main$85 = {
	__name: "EmptyState",
	__ssrInlineRender: true,
	props: {
		icon: {
			type: String,
			default: "inbox"
		},
		title: {
			type: String,
			default: "Nema rezultata"
		},
		text: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-6 py-12 text-center" }, _attrs))}><span class="flex size-16 items-center justify-center rounded-full bg-primary-tint text-primary">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: __props.icon,
				size: 28
			}, null, _parent));
			_push(`</span><h3 class="text-xl font-semibold text-heading">${ssrInterpolate(__props.title)}</h3>`);
			if (__props.text) _push(`<p class="max-w-sm text-sm text-text-muted">${ssrInterpolate(__props.text)}</p>`);
			else _push(`<!---->`);
			if (_ctx.$slots.default) {
				_push(`<div class="mt-1">`);
				ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
				_push(`</div>`);
			} else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$85 = _sfc_main$85.setup;
_sfc_main$85.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/EmptyState.vue");
	return _sfc_setup$85 ? _sfc_setup$85(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/cards/AdCard.vue
var _sfc_main$84 = {
	__name: "AdCard",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(unref(Link), mergeProps({
				href: `/oglasi/${__props.item.slug}`,
				class: ["group flex flex-col gap-2.5 rounded-md border border-border bg-surface p-4 shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]", __props.item.isteklo ? "opacity-70" : ""]
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="flex items-center justify-between gap-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.vrsta.label,
							icon: __props.item.vrsta.icon
						}, null, _parent, _scopeId));
						if (__props.item.isteklo) _push(ssrRenderComponent(_sfc_main$87, { variant: "isteklo" }, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`</div><h3 class="line-clamp-2 text-[17px] font-semibold leading-snug text-heading"${_scopeId}>${ssrInterpolate(__props.item.naslov)}</h3><div class="flex flex-col gap-1.5 text-[13px] text-text-muted"${_scopeId}><div class="flex items-center gap-1.5"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "building-2",
							size: 15
						}, null, _parent, _scopeId));
						_push(`<span${_scopeId}>${ssrInterpolate(__props.item.izdavac)}</span></div><div class="flex items-center gap-1.5"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "map-pin",
							size: 15
						}, null, _parent, _scopeId));
						_push(`<span${_scopeId}>${ssrInterpolate(__props.item.lokacija)}</span></div><div class="flex items-center gap-1.5"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "calendar",
							size: 15
						}, null, _parent, _scopeId));
						_push(`<span${_scopeId}>Rok: ${ssrInterpolate(__props.item.rok)}</span></div></div>`);
					} else return [
						createVNode("div", { class: "flex items-center justify-between gap-2" }, [createVNode(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.vrsta.label,
							icon: __props.item.vrsta.icon
						}, null, 8, ["label", "icon"]), __props.item.isteklo ? (openBlock(), createBlock(_sfc_main$87, {
							key: 0,
							variant: "isteklo"
						})) : createCommentVNode("", true)]),
						createVNode("h3", { class: "line-clamp-2 text-[17px] font-semibold leading-snug text-heading" }, toDisplayString(__props.item.naslov), 1),
						createVNode("div", { class: "flex flex-col gap-1.5 text-[13px] text-text-muted" }, [
							createVNode("div", { class: "flex items-center gap-1.5" }, [createVNode(_sfc_main$97, {
								name: "building-2",
								size: 15
							}), createVNode("span", null, toDisplayString(__props.item.izdavac), 1)]),
							createVNode("div", { class: "flex items-center gap-1.5" }, [createVNode(_sfc_main$97, {
								name: "map-pin",
								size: 15
							}), createVNode("span", null, toDisplayString(__props.item.lokacija), 1)]),
							createVNode("div", { class: "flex items-center gap-1.5" }, [createVNode(_sfc_main$97, {
								name: "calendar",
								size: 15
							}), createVNode("span", null, "Rok: " + toDisplayString(__props.item.rok), 1)])
						])
					];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$84 = _sfc_main$84.setup;
_sfc_main$84.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/cards/AdCard.vue");
	return _sfc_setup$84 ? _sfc_setup$84(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/AdDetail.vue
var AdDetail_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$83 });
var _sfc_main$83 = {
	__name: "AdDetail",
	__ssrInlineRender: true,
	props: {
		slug: {
			type: String,
			default: ""
		},
		oglas: {
			type: Object,
			default: null
		},
		slicni: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const oglas = computed(() => props.oglas);
		const slicni = computed(() => props.slicni);
		const infoItems = computed(() => {
			if (!oglas.value) return [];
			const o = oglas.value;
			const k = o.kontakt || {};
			const items = [];
			if (o.izdavac) items.push({
				icon: "building-2",
				label: "Izdavač",
				value: o.izdavac
			});
			if (o.lokacija) items.push({
				icon: "map-pin",
				label: "Lokacija",
				value: o.lokacija
			});
			if (o.rok) items.push({
				icon: "calendar",
				label: "Rok",
				value: o.rok
			});
			if (k.osoba) items.push({
				icon: "user",
				label: "Kontakt osoba",
				value: k.osoba
			});
			if (k.telefon) items.push({
				icon: "phone",
				label: "Telefon",
				value: k.telefon,
				href: `tel:${k.telefon.replace(/[^0-9+]/g, "")}`
			});
			if (k.email) items.push({
				icon: "mail",
				label: "E-mail",
				value: k.email,
				href: `mailto:${k.email}`
			});
			return items;
		});
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "py-8"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!oglas.value) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Oglas nije pronađen",
						text: "Traženi oglas ne postoji ili je uklonjen."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/oglasi"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Nazad na oglase `);
									else return [createTextVNode(" Nazad na oglase ")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/oglasi"
							}, {
								default: withCtx(() => [createTextVNode(" Nazad na oglase ")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Poslovne prilike i oglasi",
								to: "/oglasi"
							},
							{ label: oglas.value.naslov }
						] }, null, _parent, _scopeId));
						_push(`<div class="${ssrRenderClass(oglas.value.isteklo ? "opacity-70" : "")}"${_scopeId}><header class="mt-6"${_scopeId}><div class="flex flex-wrap items-center gap-3"${_scopeId}>`);
						if (oglas.value.vrsta) _push(ssrRenderComponent(_sfc_main$88, {
							variant: "kategorija",
							label: oglas.value.vrsta.label,
							icon: oglas.value.vrsta.icon
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						if (oglas.value.isteklo) _push(ssrRenderComponent(_sfc_main$87, { variant: "isteklo" }, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`</div><h1 class="mt-3 font-heading text-3xl font-bold text-heading md:text-4xl"${_scopeId}>${ssrInterpolate(oglas.value.naslov)}</h1></header><div class="mt-8 grid gap-8 lg:grid-cols-3"${_scopeId}><div class="lg:col-span-2"${_scopeId}><h2 class="mb-3 font-heading text-2xl font-bold text-heading"${_scopeId}>Opis oglasa</h2><p class="whitespace-pre-line leading-relaxed text-text"${_scopeId}>${ssrInterpolate(oglas.value.opisDug)}</p></div><div${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$91, {
							title: "Detalji",
							items: infoItems.value
						}, null, _parent, _scopeId));
						_push(`</div></div></div>`);
						if (slicni.value.length) _push(ssrRenderComponent(_sfc_main$89, { title: "Slični oglasi" }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(slicni.value, (o) => {
										_push(ssrRenderComponent(_sfc_main$84, {
											key: o.slug,
											item: o
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (o) => {
									return openBlock(), createBlock(_sfc_main$84, {
										key: o.slug,
										item: o
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!oglas.value ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Oglas nije pronađen",
						text: "Traženi oglas ne postoji ili je uklonjen."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "arrow-left",
							to: "/oglasi"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na oglase ")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [
						createVNode(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Poslovne prilike i oglasi",
								to: "/oglasi"
							},
							{ label: oglas.value.naslov }
						] }, null, 8, ["items"]),
						createVNode("div", { class: oglas.value.isteklo ? "opacity-70" : "" }, [createVNode("header", { class: "mt-6" }, [createVNode("div", { class: "flex flex-wrap items-center gap-3" }, [oglas.value.vrsta ? (openBlock(), createBlock(_sfc_main$88, {
							key: 0,
							variant: "kategorija",
							label: oglas.value.vrsta.label,
							icon: oglas.value.vrsta.icon
						}, null, 8, ["label", "icon"])) : createCommentVNode("", true), oglas.value.isteklo ? (openBlock(), createBlock(_sfc_main$87, {
							key: 1,
							variant: "isteklo"
						})) : createCommentVNode("", true)]), createVNode("h1", { class: "mt-3 font-heading text-3xl font-bold text-heading md:text-4xl" }, toDisplayString(oglas.value.naslov), 1)]), createVNode("div", { class: "mt-8 grid gap-8 lg:grid-cols-3" }, [createVNode("div", { class: "lg:col-span-2" }, [createVNode("h2", { class: "mb-3 font-heading text-2xl font-bold text-heading" }, "Opis oglasa"), createVNode("p", { class: "whitespace-pre-line leading-relaxed text-text" }, toDisplayString(oglas.value.opisDug), 1)]), createVNode("div", null, [createVNode(_sfc_main$91, {
							title: "Detalji",
							items: infoItems.value
						}, null, 8, ["items"])])])], 2),
						slicni.value.length ? (openBlock(), createBlock(_sfc_main$89, {
							key: 0,
							title: "Slični oglasi"
						}, {
							default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (o) => {
								return openBlock(), createBlock(_sfc_main$84, {
									key: o.slug,
									item: o
								}, null, 8, ["item"]);
							}), 128))]),
							_: 1
						})) : createCommentVNode("", true)
					], 64))];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$83 = _sfc_main$83.setup;
_sfc_main$83.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/AdDetail.vue");
	return _sfc_setup$83 ? _sfc_setup$83(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/SegmentControl.vue
var _sfc_main$82 = {
	__name: "SegmentControl",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({ options: {
		type: Array,
		default: () => []
	} }, {
		"modelValue": {},
		"modelModifiers": {}
	}),
	emits: ["update:modelValue"],
	setup(__props) {
		const model = useModel(__props, "modelValue");
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({
				class: "inline-flex rounded-sm bg-surface-alt p-1",
				role: "tablist"
			}, _attrs))}><!--[-->`);
			ssrRenderList(__props.options, (opt) => {
				_push(`<button type="button" role="tab"${ssrRenderAttr("aria-selected", model.value === opt.value)} class="${ssrRenderClass([model.value === opt.value ? "bg-primary text-white shadow-[var(--shadow-sm)]" : "text-text hover:text-primary", "inline-flex h-9 items-center justify-center gap-1.5 rounded-sm px-4 text-sm font-semibold transition-colors"])}">`);
				if (opt.icon) _push(ssrRenderComponent(_sfc_main$97, {
					name: opt.icon,
					size: 16
				}, null, _parent));
				else _push(`<!---->`);
				_push(`<span>${ssrInterpolate(opt.label)}</span></button>`);
			});
			_push(`<!--]--></div>`);
		};
	}
};
var _sfc_setup$82 = _sfc_main$82.setup;
_sfc_main$82.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/SegmentControl.vue");
	return _sfc_setup$82 ? _sfc_setup$82(props, ctx) : void 0;
};
//#endregion
//#region \0plugin-vue:export-helper
var _plugin_vue_export_helper_default = (sfc, props) => {
	const target = sfc.__vccOpts || sfc;
	for (const [key, val] of props) target[key] = val;
	return target;
};
//#endregion
//#region resources/js/components/common/FilterDrawer.vue
var _sfc_main$81 = {
	__name: "FilterDrawer",
	__ssrInlineRender: true,
	props: {
		"modelValue": {
			type: Boolean,
			default: false
		},
		"modelModifiers": {}
	},
	emits: ["update:modelValue"],
	setup(__props) {
		const open = useModel(__props, "modelValue");
		function close() {
			open.value = false;
		}
		watch(open, (v) => {
			document.body.style.overflow = v ? "hidden" : "";
		});
		return (_ctx, _push, _parent, _attrs) => {
			ssrRenderTeleport(_push, (_push) => {
				if (open.value) {
					_push(`<div class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true" data-v-ddf15c08><div class="absolute inset-0 bg-overlay" data-v-ddf15c08></div><section class="absolute inset-x-0 bottom-0 flex max-h-[85%] flex-col rounded-t-lg bg-surface shadow-[var(--shadow-lg)]" data-v-ddf15c08><div class="flex h-14 shrink-0 items-center justify-between border-b border-border px-4" data-v-ddf15c08><h2 class="text-lg font-semibold text-heading" data-v-ddf15c08>Filteri</h2><button type="button" class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt" aria-label="Zatvori filtere" data-v-ddf15c08>`);
					_push(ssrRenderComponent(_sfc_main$97, {
						name: "x",
						size: 22
					}, null, _parent));
					_push(`</button></div><div class="flex-1 space-y-4 overflow-y-auto p-4" data-v-ddf15c08>`);
					ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
					_push(`</div><div class="shrink-0 border-t border-border p-4" data-v-ddf15c08>`);
					_push(ssrRenderComponent(_sfc_main$93, {
						variant: "primary",
						block: "",
						onClick: close
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(`Prikaži rezultate`);
							else return [createTextVNode("Prikaži rezultate")];
						}),
						_: 1
					}, _parent));
					_push(`</div></section></div>`);
				} else _push(`<!---->`);
			}, "body", false, _parent);
		};
	}
};
var _sfc_setup$81 = _sfc_main$81.setup;
_sfc_main$81.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/FilterDrawer.vue");
	return _sfc_setup$81 ? _sfc_setup$81(props, ctx) : void 0;
};
var FilterDrawer_default = /*#__PURE__*/ _plugin_vue_export_helper_default(_sfc_main$81, [["__scopeId", "data-v-ddf15c08"]]);
//#endregion
//#region resources/js/components/common/FilterBar.vue
var _sfc_main$80 = {
	__name: "FilterBar",
	__ssrInlineRender: true,
	props: { chips: {
		type: Array,
		default: () => []
	} },
	emits: ["clear", "remove"],
	setup(__props, { emit: __emit }) {
		const emit = __emit;
		const open = ref(false);
		const isDesktop = ref(true);
		let mq = null;
		function update(e) {
			isDesktop.value = e.matches;
		}
		onMounted(() => {
			mq = window.matchMedia("(min-width: 1024px)");
			isDesktop.value = mq.matches;
			mq.addEventListener("change", update);
		});
		onUnmounted(() => {
			mq?.removeEventListener("change", update);
		});
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "space-y-3" }, _attrs))}>`);
			if (isDesktop.value) {
				_push(`<div class="flex items-end gap-3"><div class="flex flex-1 flex-wrap items-end gap-3">`);
				ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
				_push(`</div>`);
				_push(ssrRenderComponent(_sfc_main$93, {
					variant: "ghost",
					size: "sm",
					onClick: ($event) => emit("clear")
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(`Očisti filtere`);
						else return [createTextVNode("Očisti filtere")];
					}),
					_: 1
				}, _parent));
				_push(`</div>`);
			} else {
				_push(`<div>`);
				_push(ssrRenderComponent(_sfc_main$93, {
					variant: "secondary",
					icon: "filter",
					block: "",
					onClick: ($event) => open.value = true
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(`Filteri`);
						else return [createTextVNode("Filteri")];
					}),
					_: 1
				}, _parent));
				_push(ssrRenderComponent(FilterDrawer_default, {
					modelValue: open.value,
					"onUpdate:modelValue": ($event) => open.value = $event
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent, _scopeId);
						else return [renderSlot(_ctx.$slots, "default")];
					}),
					_: 3
				}, _parent));
				_push(`</div>`);
			}
			if (__props.chips.length) {
				_push(`<div class="flex flex-wrap items-center gap-2"><!--[-->`);
				ssrRenderList(__props.chips, (chip) => {
					_push(ssrRenderComponent(_sfc_main$88, {
						key: chip.key,
						variant: "uklonjiv",
						label: chip.label,
						onRemove: ($event) => emit("remove", chip.key)
					}, null, _parent));
				});
				_push(`<!--]--><button type="button" class="ml-1 text-sm font-medium text-primary underline-offset-2 hover:underline"> Očisti filtere </button></div>`);
			} else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$80 = _sfc_main$80.setup;
_sfc_main$80.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/FilterBar.vue");
	return _sfc_setup$80 ? _sfc_setup$80(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/SearchInput.vue
var _sfc_main$79 = {
	__name: "SearchInput",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({ placeholder: {
		type: String,
		default: "Pretraga…"
	} }, {
		"modelValue": {
			type: String,
			default: ""
		},
		"modelModifiers": {}
	}),
	emits: /*@__PURE__*/ mergeModels(["submit"], ["update:modelValue"]),
	setup(__props, { emit: __emit }) {
		const model = useModel(__props, "modelValue");
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<form${ssrRenderAttrs(mergeProps({
				role: "search",
				class: "relative"
			}, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "search",
				size: 18,
				class: "pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"
			}, null, _parent));
			_push(`<input${ssrRenderAttr("value", model.value)} type="search"${ssrRenderAttr("placeholder", __props.placeholder)} class="h-11 w-full rounded-sm border border-border bg-surface pl-10 pr-10 text-text outline-none transition-colors placeholder:text-text-muted focus:border-primary">`);
			if (model.value) {
				_push(`<button type="button" class="absolute right-2 top-1/2 inline-flex size-7 -translate-y-1/2 items-center justify-center rounded-full text-text-muted transition-colors hover:bg-surface-alt hover:text-heading" aria-label="Očisti pretragu">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: "x",
					size: 16
				}, null, _parent));
				_push(`</button>`);
			} else _push(`<!---->`);
			_push(`</form>`);
		};
	}
};
var _sfc_setup$79 = _sfc_main$79.setup;
_sfc_main$79.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/SearchInput.vue");
	return _sfc_setup$79 ? _sfc_setup$79(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/forms/FormSelect.vue
var _sfc_main$78 = {
	__name: "FormSelect",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({
		label: {
			type: String,
			default: ""
		},
		options: {
			type: Array,
			default: () => []
		},
		placeholder: {
			type: String,
			default: "Odaberite…"
		},
		helper: {
			type: String,
			default: ""
		},
		error: {
			type: String,
			default: ""
		},
		required: {
			type: Boolean,
			default: false
		},
		disabled: {
			type: Boolean,
			default: false
		}
	}, {
		"modelValue": {
			type: [String, Number],
			default: ""
		},
		"modelModifiers": {}
	}),
	emits: ["update:modelValue"],
	setup(__props) {
		const model = useModel(__props, "modelValue");
		const id = useId();
		const normalize = (o) => typeof o === "object" ? o : {
			value: o,
			label: o
		};
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col gap-1.5" }, _attrs))}>`);
			if (__props.label) {
				_push(`<label${ssrRenderAttr("for", unref(id))} class="text-sm font-semibold text-heading">${ssrInterpolate(__props.label)} `);
				if (__props.required) _push(`<span class="text-error">*</span>`);
				else _push(`<!---->`);
				_push(`</label>`);
			} else _push(`<!---->`);
			_push(`<div class="relative"><select${ssrRenderAttr("id", unref(id))}${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""}${ssrRenderAttr("aria-invalid", __props.error ? "true" : void 0)} class="${ssrRenderClass([[__props.error ? "border-error" : "border-border", model.value ? "text-text" : "text-text-muted"], "h-11 w-full appearance-none rounded-sm border bg-surface px-4 pr-10 text-text outline-none transition-colors focus:border-primary disabled:bg-surface-alt disabled:opacity-60"])}"><option value="" disabled${ssrIncludeBooleanAttr(Array.isArray(model.value) ? ssrLooseContain(model.value, "") : ssrLooseEqual(model.value, "")) ? " selected" : ""}>${ssrInterpolate(__props.placeholder)}</option><!--[-->`);
			ssrRenderList(__props.options, (o) => {
				_push(`<option${ssrRenderAttr("value", normalize(o).value)}${ssrIncludeBooleanAttr(Array.isArray(model.value) ? ssrLooseContain(model.value, normalize(o).value) : ssrLooseEqual(model.value, normalize(o).value)) ? " selected" : ""}>${ssrInterpolate(normalize(o).label)}</option>`);
			});
			_push(`<!--]--></select>`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "chevron-down",
				size: 18,
				class: "pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-text-muted"
			}, null, _parent));
			_push(`</div>`);
			if (__props.error) _push(`<p class="text-[13px] text-error">${ssrInterpolate(__props.error)}</p>`);
			else if (__props.helper) _push(`<p class="text-[13px] text-text-muted">${ssrInterpolate(__props.helper)}</p>`);
			else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$78 = _sfc_main$78.setup;
_sfc_main$78.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/forms/FormSelect.vue");
	return _sfc_setup$78 ? _sfc_setup$78(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/Pagination.vue
var _sfc_main$77 = {
	__name: "Pagination",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({ total: {
		type: Number,
		default: 1
	} }, {
		"modelValue": {
			type: Number,
			default: 1
		},
		"modelModifiers": {}
	}),
	emits: ["update:modelValue"],
	setup(__props) {
		const current = useModel(__props, "modelValue");
		const props = __props;
		const pages = computed(() => {
			const t = props.total;
			const c = current.value;
			if (t <= 7) return Array.from({ length: t }, (_, i) => i + 1);
			const out = [1];
			if (c > 3) out.push("…");
			const start = Math.max(2, c - 1);
			const end = Math.min(t - 1, c + 1);
			for (let i = start; i <= end; i++) out.push(i);
			if (c < t - 2) out.push("…");
			out.push(t);
			return out;
		});
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<nav${ssrRenderAttrs(mergeProps({
				class: "flex items-center gap-2",
				"aria-label": "Stranice"
			}, _attrs))}><button type="button" class="grid size-10 place-items-center rounded-sm border border-border text-text transition-colors hover:bg-surface-alt disabled:opacity-40"${ssrIncludeBooleanAttr(current.value <= 1) ? " disabled" : ""} aria-label="Prethodna stranica">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "chevron-left",
				size: 18
			}, null, _parent));
			_push(`</button><!--[-->`);
			ssrRenderList(pages.value, (p, i) => {
				_push(`<!--[-->`);
				if (p === "…") _push(`<span class="grid size-10 place-items-center text-text-muted">…</span>`);
				else _push(`<button type="button" class="${ssrRenderClass([p === current.value ? "border-primary bg-primary text-white" : "border-border text-text hover:bg-surface-alt", "grid size-10 place-items-center rounded-sm border text-sm font-medium transition-colors"])}"${ssrRenderAttr("aria-current", p === current.value ? "page" : void 0)}>${ssrInterpolate(p)}</button>`);
				_push(`<!--]-->`);
			});
			_push(`<!--]--><button type="button" class="grid size-10 place-items-center rounded-sm border border-border text-text transition-colors hover:bg-surface-alt disabled:opacity-40"${ssrIncludeBooleanAttr(current.value >= __props.total) ? " disabled" : ""} aria-label="Sljedeća stranica">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "chevron-right",
				size: 18
			}, null, _parent));
			_push(`</button></nav>`);
		};
	}
};
var _sfc_setup$77 = _sfc_main$77.setup;
_sfc_main$77.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/Pagination.vue");
	return _sfc_setup$77 ? _sfc_setup$77(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/Skeleton.vue
var _sfc_main$76 = {
	__name: "Skeleton",
	__ssrInlineRender: true,
	props: { count: {
		type: Number,
		default: 1
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<!--[-->`);
			ssrRenderList(__props.count, (n) => {
				_push(`<div class="overflow-hidden rounded-md border border-border bg-surface" aria-hidden="true"><div class="aspect-[16/10] animate-pulse bg-neutral-tint"></div><div class="flex flex-col gap-2.5 p-4"><div class="h-5 w-20 animate-pulse rounded-pill bg-neutral-tint"></div><div class="h-4 w-full animate-pulse rounded bg-neutral-tint"></div><div class="h-3 w-full animate-pulse rounded bg-neutral-tint"></div><div class="h-3 w-40 animate-pulse rounded bg-neutral-tint"></div></div></div>`);
			});
			_push(`<!--]-->`);
		};
	}
};
var _sfc_setup$76 = _sfc_main$76.setup;
_sfc_main$76.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/Skeleton.vue");
	return _sfc_setup$76 ? _sfc_setup$76(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/AdsListing.vue
var AdsListing_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$75 });
var PO_STRANICI$4 = 8;
var _sfc_main$75 = {
	__name: "AdsListing",
	__ssrInlineRender: true,
	props: { oglasi: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		const props = __props;
		const data = computed(() => props.oglasi);
		const upit = ref("");
		const vrsta = ref("");
		const status = ref("aktivni");
		const stranica = ref(1);
		const statusOpcije = [{
			value: "aktivni",
			label: "Aktivni"
		}, {
			value: "arhiva",
			label: "Arhiva"
		}];
		const vrsteOpcije = computed(() => {
			const map = /* @__PURE__ */ new Map();
			for (const o of data.value || []) if (o.vrsta?.label) map.set(o.vrsta.label, o.vrsta.label);
			return [...map.values()].map((label) => ({
				value: label,
				label
			}));
		});
		const filtrirano = computed(() => {
			let lista = data.value || [];
			lista = lista.filter((o) => status.value === "arhiva" ? o.isteklo : !o.isteklo);
			if (vrsta.value) lista = lista.filter((o) => o.vrsta?.label === vrsta.value);
			if (upit.value.trim()) {
				const q = upit.value.trim().toLowerCase();
				lista = lista.filter((o) => o.naslov?.toLowerCase().includes(q) || o.izdavac?.toLowerCase().includes(q) || o.lokacija?.toLowerCase().includes(q));
			}
			return lista;
		});
		const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI$4)));
		const vidljivi = computed(() => filtrirano.value.slice((stranica.value - 1) * PO_STRANICI$4, stranica.value * PO_STRANICI$4));
		const aktivniChipovi = computed(() => {
			const chips = [];
			if (vrsta.value) chips.push({
				key: "vrsta",
				label: vrsta.value
			});
			if (upit.value.trim()) chips.push({
				key: "upit",
				label: `„${upit.value.trim()}”`
			});
			return chips;
		});
		watch([
			vrsta,
			upit,
			status
		], () => {
			stranica.value = 1;
		});
		function ocisti() {
			vrsta.value = "";
			upit.value = "";
		}
		function ukloni(key) {
			if (key === "vrsta") vrsta.value = "";
			if (key === "upit") upit.value = "";
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Oglasi" }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Oglasi" }] })];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="flex flex-wrap items-start justify-between gap-4"${_scopeId}><div${_scopeId}><h1 class="font-heading text-3xl font-bold text-heading md:text-4xl"${_scopeId}> Poslovne prilike i oglasi </h1><p class="mt-2 max-w-2xl text-text-muted"${_scopeId}> Zapošljavanje, saradnja, usluge i konkursi iz Teslića i okoline. </p></div>`);
						_push(ssrRenderComponent(_sfc_main$82, {
							modelValue: status.value,
							"onUpdate:modelValue": ($event) => status.value = $event,
							options: statusOpcije
						}, null, _parent, _scopeId));
						_push(`</div>`);
					} else return [createVNode("div", { class: "flex flex-wrap items-start justify-between gap-4" }, [createVNode("div", null, [createVNode("h1", { class: "font-heading text-3xl font-bold text-heading md:text-4xl" }, " Poslovne prilike i oglasi "), createVNode("p", { class: "mt-2 max-w-2xl text-text-muted" }, " Zapošljavanje, saradnja, usluge i konkursi iz Teslića i okoline. ")]), createVNode(_sfc_main$82, {
						modelValue: status.value,
						"onUpdate:modelValue": ($event) => status.value = $event,
						options: statusOpcije
					}, null, 8, ["modelValue", "onUpdate:modelValue"])])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) {
								_push(ssrRenderComponent(_sfc_main$78, {
									modelValue: vrsta.value,
									"onUpdate:modelValue": ($event) => vrsta.value = $event,
									options: vrsteOpcije.value,
									placeholder: "Sve vrste"
								}, null, _parent, _scopeId));
								_push(ssrRenderComponent(_sfc_main$79, {
									modelValue: upit.value,
									"onUpdate:modelValue": ($event) => upit.value = $event,
									placeholder: "Pretraži oglase…"
								}, null, _parent, _scopeId));
							} else return [createVNode(_sfc_main$78, {
								modelValue: vrsta.value,
								"onUpdate:modelValue": ($event) => vrsta.value = $event,
								options: vrsteOpcije.value,
								placeholder: "Sve vrste"
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"options"
							]), createVNode(_sfc_main$79, {
								modelValue: upit.value,
								"onUpdate:modelValue": ($event) => upit.value = $event,
								placeholder: "Pretraži oglase…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx(() => [createVNode(_sfc_main$78, {
							modelValue: vrsta.value,
							"onUpdate:modelValue": ($event) => vrsta.value = $event,
							options: vrsteOpcije.value,
							placeholder: "Sve vrste"
						}, null, 8, [
							"modelValue",
							"onUpdate:modelValue",
							"options"
						]), createVNode(_sfc_main$79, {
							modelValue: upit.value,
							"onUpdate:modelValue": ($event) => upit.value = $event,
							placeholder: "Pretraži oglase…"
						}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
						_: 1
					}, 8, ["chips"])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!vidljivi.value.length) _push(ssrRenderComponent(_sfc_main$85, {
						title: status.value === "arhiva" ? "Nema arhiviranih oglasa" : "Nema aktivnih oglasa",
						text: "Za odabrane filtere trenutno nema oglasa. Pokušajte promijeniti pretragu ili pogledajte arhivu."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) if (status.value === "aktivni") _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ($event) => status.value = "arhiva"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Pogledaj arhivu `);
									else return [createTextVNode(" Pogledaj arhivu ")];
								}),
								_: 1
							}, _parent, _scopeId));
							else _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ($event) => status.value = "aktivni"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Aktivni oglasi `);
									else return [createTextVNode(" Aktivni oglasi ")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [status.value === "aktivni" ? (openBlock(), createBlock(_sfc_main$93, {
								key: 0,
								variant: "secondary",
								size: "sm",
								onClick: ($event) => status.value = "arhiva"
							}, {
								default: withCtx(() => [createTextVNode(" Pogledaj arhivu ")]),
								_: 1
							}, 8, ["onClick"])) : (openBlock(), createBlock(_sfc_main$93, {
								key: 1,
								variant: "secondary",
								size: "sm",
								onClick: ($event) => status.value = "aktivni"
							}, {
								default: withCtx(() => [createTextVNode(" Aktivni oglasi ")]),
								_: 1
							}, 8, ["onClick"]))];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(vidljivi.value, (o) => {
										_push(ssrRenderComponent(_sfc_main$84, {
											key: o.slug,
											item: o
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (o) => {
									return openBlock(), createBlock(_sfc_main$84, {
										key: o.slug,
										item: o
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						if (ukupnoStranica.value > 1) {
							_push(`<div class="mt-10 flex justify-center"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$77, {
								modelValue: stranica.value,
								"onUpdate:modelValue": ($event) => stranica.value = $event,
								total: ukupnoStranica.value
							}, null, _parent, _scopeId));
							_push(`</div>`);
						} else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!vidljivi.value.length ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: status.value === "arhiva" ? "Nema arhiviranih oglasa" : "Nema aktivnih oglasa",
						text: "Za odabrane filtere trenutno nema oglasa. Pokušajte promijeniti pretragu ili pogledajte arhivu."
					}, {
						default: withCtx(() => [status.value === "aktivni" ? (openBlock(), createBlock(_sfc_main$93, {
							key: 0,
							variant: "secondary",
							size: "sm",
							onClick: ($event) => status.value = "arhiva"
						}, {
							default: withCtx(() => [createTextVNode(" Pogledaj arhivu ")]),
							_: 1
						}, 8, ["onClick"])) : (openBlock(), createBlock(_sfc_main$93, {
							key: 1,
							variant: "secondary",
							size: "sm",
							onClick: ($event) => status.value = "aktivni"
						}, {
							default: withCtx(() => [createTextVNode(" Aktivni oglasi ")]),
							_: 1
						}, 8, ["onClick"]))]),
						_: 1
					}, 8, ["title"])) : (openBlock(), createBlock(Fragment, { key: 3 }, [createVNode(_sfc_main$90, { cols: 3 }, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (o) => {
							return openBlock(), createBlock(_sfc_main$84, {
								key: o.slug,
								item: o
							}, null, 8, ["item"]);
						}), 128))]),
						_: 1
					}), ukupnoStranica.value > 1 ? (openBlock(), createBlock("div", {
						key: 0,
						class: "mt-10 flex justify-center"
					}, [createVNode(_sfc_main$77, {
						modelValue: stranica.value,
						"onUpdate:modelValue": ($event) => stranica.value = $event,
						total: ukupnoStranica.value
					}, null, 8, [
						"modelValue",
						"onUpdate:modelValue",
						"total"
					])])) : createCommentVNode("", true)], 64))];
				}),
				_: 1
			}, _parent));
			_push(`</main>`);
		};
	}
};
var _sfc_setup$75 = _sfc_main$75.setup;
_sfc_main$75.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/AdsListing.vue");
	return _sfc_setup$75 ? _sfc_setup$75(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/Lightbox.vue
var _sfc_main$74 = {
	__name: "Lightbox",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({
		items: {
			type: Array,
			default: () => []
		},
		startIndex: {
			type: Number,
			default: 0
		}
	}, {
		"modelValue": { type: Boolean },
		"modelModifiers": {}
	}),
	emits: ["update:modelValue"],
	setup(__props) {
		const open = useModel(__props, "modelValue");
		const props = __props;
		const index = ref(props.startIndex);
		const current = computed(() => props.items[index.value] || null);
		const total = computed(() => props.items.length);
		function clamp(i) {
			if (total.value === 0) return 0;
			return (i + total.value) % total.value;
		}
		function next() {
			index.value = clamp(index.value + 1);
		}
		function prev() {
			index.value = clamp(index.value - 1);
		}
		function close() {
			open.value = false;
		}
		function onKeydown(e) {
			if (e.key === "Escape") close();
			else if (e.key === "ArrowRight") next();
			else if (e.key === "ArrowLeft") prev();
		}
		watch(open, (v) => {
			if (v) {
				index.value = clamp(props.startIndex);
				document.body.style.overflow = "hidden";
				window.addEventListener("keydown", onKeydown);
			} else {
				document.body.style.overflow = "";
				window.removeEventListener("keydown", onKeydown);
			}
		});
		onBeforeUnmount(() => {
			document.body.style.overflow = "";
			window.removeEventListener("keydown", onKeydown);
		});
		return (_ctx, _push, _parent, _attrs) => {
			ssrRenderTeleport(_push, (_push) => {
				if (open.value) {
					_push(`<div class="fixed inset-0 z-[60] flex items-center justify-center bg-overlay" role="dialog" aria-modal="true" data-v-84b4797a><button type="button" class="absolute right-4 top-4 inline-flex size-11 items-center justify-center rounded-sm text-white hover:bg-white/10" aria-label="Zatvori" data-v-84b4797a>`);
					_push(ssrRenderComponent(_sfc_main$97, {
						name: "x",
						size: 26
					}, null, _parent));
					_push(`</button>`);
					if (total.value > 1) {
						_push(`<button type="button" class="absolute left-2 top-1/2 inline-flex size-11 -translate-y-1/2 items-center justify-center rounded-sm text-white hover:bg-white/10 sm:left-4" aria-label="Prethodno" data-v-84b4797a>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "chevron-left",
							size: 32
						}, null, _parent));
						_push(`</button>`);
					} else _push(`<!---->`);
					_push(`<div class="flex max-h-[88vh] max-w-[92vw] items-center justify-center" data-v-84b4797a>`);
					if (current.value && current.value.type === "video") _push(`<video${ssrRenderAttr("src", current.value.src)} controls autoplay class="max-h-[88vh] max-w-[92vw] rounded-md bg-black object-contain" data-v-84b4797a></video>`);
					else if (current.value) _push(`<img${ssrRenderAttr("src", current.value.src)}${ssrRenderAttr("alt", current.value.alt || "")} class="max-h-[88vh] max-w-[92vw] rounded-md object-contain" data-v-84b4797a>`);
					else _push(`<!---->`);
					_push(`</div>`);
					if (total.value > 1) {
						_push(`<button type="button" class="absolute right-2 top-1/2 inline-flex size-11 -translate-y-1/2 items-center justify-center rounded-sm text-white hover:bg-white/10 sm:right-4" aria-label="Sljedeće" data-v-84b4797a>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "chevron-right",
							size: 32
						}, null, _parent));
						_push(`</button>`);
					} else _push(`<!---->`);
					if (total.value > 1) _push(`<div class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-pill bg-black/50 px-3 py-1 text-sm font-medium text-white" data-v-84b4797a>${ssrInterpolate(index.value + 1)} / ${ssrInterpolate(total.value)}</div>`);
					else _push(`<!---->`);
					_push(`</div>`);
				} else _push(`<!---->`);
			}, "body", false, _parent);
		};
	}
};
var _sfc_setup$74 = _sfc_main$74.setup;
_sfc_main$74.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/Lightbox.vue");
	return _sfc_setup$74 ? _sfc_setup$74(props, ctx) : void 0;
};
var Lightbox_default = /*#__PURE__*/ _plugin_vue_export_helper_default(_sfc_main$74, [["__scopeId", "data-v-84b4797a"]]);
//#endregion
//#region resources/js/components/common/Gallery.vue
var _sfc_main$73 = {
	__name: "Gallery",
	__ssrInlineRender: true,
	props: {
		items: {
			type: Array,
			default: () => []
		},
		variant: {
			type: String,
			default: "grid",
			validator: (v) => ["grid", "carousel"].includes(v)
		}
	},
	setup(__props) {
		const open = ref(false);
		const index = ref(0);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(_attrs)}>`);
			if (__props.variant === "grid") {
				_push(`<div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"><!--[-->`);
				ssrRenderList(__props.items, (item, i) => {
					_push(`<button type="button" class="group relative aspect-square overflow-hidden rounded-md bg-primary-tint"${ssrRenderAttr("aria-label", item.alt || "Otvori stavku galerije")}><img${ssrRenderAttr("src", item.src)}${ssrRenderAttr("alt", item.alt || "")} loading="lazy" class="size-full object-cover transition-transform duration-300 group-hover:scale-105">`);
					if (item.type === "video") {
						_push(`<span class="absolute inset-0 flex items-center justify-center bg-black/30 text-white">`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "play",
							size: 36
						}, null, _parent));
						_push(`</span>`);
					} else _push(`<!---->`);
					_push(`</button>`);
				});
				_push(`<!--]--></div>`);
			} else {
				_push(`<div class="flex snap-x snap-mandatory gap-3 overflow-x-auto pb-2"><!--[-->`);
				ssrRenderList(__props.items, (item, i) => {
					_push(`<button type="button" class="group relative aspect-square w-40 shrink-0 snap-start overflow-hidden rounded-md bg-primary-tint sm:w-48"${ssrRenderAttr("aria-label", item.alt || "Otvori stavku galerije")}><img${ssrRenderAttr("src", item.src)}${ssrRenderAttr("alt", item.alt || "")} loading="lazy" class="size-full object-cover transition-transform duration-300 group-hover:scale-105">`);
					if (item.type === "video") {
						_push(`<span class="absolute inset-0 flex items-center justify-center bg-black/30 text-white">`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "play",
							size: 36
						}, null, _parent));
						_push(`</span>`);
					} else _push(`<!---->`);
					_push(`</button>`);
				});
				_push(`<!--]--></div>`);
			}
			_push(ssrRenderComponent(Lightbox_default, {
				modelValue: open.value,
				"onUpdate:modelValue": ($event) => open.value = $event,
				items: __props.items,
				"start-index": index.value
			}, null, _parent));
			_push(`</div>`);
		};
	}
};
var _sfc_setup$73 = _sfc_main$73.setup;
_sfc_main$73.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/Gallery.vue");
	return _sfc_setup$73 ? _sfc_setup$73(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/MiniMap.vue
var _sfc_main$72 = {
	__name: "MiniMap",
	__ssrInlineRender: true,
	props: {
		label: {
			type: String,
			default: ""
		},
		to: {
			type: [String, Object],
			default: "/mapa"
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)]" }, _attrs))}><div class="relative flex h-[180px] items-center justify-center bg-primary-tint" role="img"${ssrRenderAttr("aria-label", __props.label ? `Mapa: ${__props.label}` : "Mapa")}><span class="pointer-events-none absolute inset-0 opacity-40" style="${ssrRenderStyle({
				"background-image": "linear-gradient(var(--color-primary-tint-2) 1px, transparent 1px),\n            linear-gradient(90deg, var(--color-primary-tint-2) 1px, transparent 1px)",
				"background-size": "28px 28px"
			})}" aria-hidden="true"></span><span class="relative text-primary">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "map-pin",
				size: 48
			}, null, _parent));
			_push(`</span></div><div class="flex flex-col gap-3 p-4">`);
			if (__props.label) {
				_push(`<div class="flex items-center gap-2 text-text"><span class="shrink-0 text-primary">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: "map-pin",
					size: 18
				}, null, _parent));
				_push(`</span><span class="font-medium">${ssrInterpolate(__props.label)}</span></div>`);
			} else _push(`<!---->`);
			_push(ssrRenderComponent(_sfc_main$93, {
				variant: "secondary",
				size: "sm",
				icon: "map",
				to: __props.to,
				block: ""
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(` Prikaži na mapi `);
					else return [createTextVNode(" Prikaži na mapi ")];
				}),
				_: 1
			}, _parent));
			_push(`</div></div>`);
		};
	}
};
var _sfc_setup$72 = _sfc_main$72.setup;
_sfc_main$72.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/MiniMap.vue");
	return _sfc_setup$72 ? _sfc_setup$72(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/cards/CardImage.vue
var _sfc_main$71 = {
	__name: "CardImage",
	__ssrInlineRender: true,
	props: {
		src: {
			type: String,
			default: ""
		},
		alt: {
			type: String,
			default: ""
		},
		ratio: {
			type: String,
			default: "16 / 10"
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({
				class: "relative overflow-hidden bg-primary-tint",
				style: { aspectRatio: __props.ratio }
			}, _attrs))}>`);
			if (__props.src) _push(`<img${ssrRenderAttr("src", __props.src)}${ssrRenderAttr("alt", __props.alt)} loading="lazy" class="size-full object-cover transition-transform duration-300 group-hover:scale-105">`);
			else {
				_push(`<div class="flex size-full items-center justify-center text-primary-tint-2">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: "image",
					size: 36
				}, null, _parent));
				_push(`</div>`);
			}
			ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$71 = _sfc_main$71.setup;
_sfc_main$71.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/cards/CardImage.vue");
	return _sfc_setup$71 ? _sfc_setup$71(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/cards/BusinessCard.vue
var _sfc_main$70 = {
	__name: "BusinessCard",
	__ssrInlineRender: true,
	props: {
		item: {
			type: Object,
			required: true
		},
		to: {
			type: [String, Object],
			default: null
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(unref(Link), mergeProps({
				href: __props.to || `/domace-je-najbolje/${__props.item.slug}`,
				class: "group flex flex-col overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$71, {
							src: __props.item.slika,
							alt: __props.item.naslov
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) if (__props.item.preporuceno) _push(ssrRenderComponent(_sfc_main$87, {
									variant: "preporuceno",
									class: "absolute left-3 top-3 shadow-[var(--shadow-sm)]"
								}, null, _parent, _scopeId));
								else _push(`<!---->`);
								else return [__props.item.preporuceno ? (openBlock(), createBlock(_sfc_main$87, {
									key: 0,
									variant: "preporuceno",
									class: "absolute left-3 top-3 shadow-[var(--shadow-sm)]"
								})) : createCommentVNode("", true)];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`<div class="flex flex-col gap-2 p-4"${_scopeId}><div${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.kategorija.label,
							icon: __props.item.kategorija.icon
						}, null, _parent, _scopeId));
						_push(`</div><h3 class="line-clamp-2 text-lg font-semibold leading-snug text-heading"${_scopeId}>${ssrInterpolate(__props.item.naslov)}</h3><p class="line-clamp-2 text-sm text-text-muted"${_scopeId}>${ssrInterpolate(__props.item.opis)}</p><div class="mt-auto flex items-center gap-1.5 pt-1 text-[13px] text-text-muted"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "map-pin",
							size: 15
						}, null, _parent, _scopeId));
						_push(`<span${_scopeId}>${ssrInterpolate(__props.item.lokacija)}</span></div></div>`);
					} else return [createVNode(_sfc_main$71, {
						src: __props.item.slika,
						alt: __props.item.naslov
					}, {
						default: withCtx(() => [__props.item.preporuceno ? (openBlock(), createBlock(_sfc_main$87, {
							key: 0,
							variant: "preporuceno",
							class: "absolute left-3 top-3 shadow-[var(--shadow-sm)]"
						})) : createCommentVNode("", true)]),
						_: 1
					}, 8, ["src", "alt"]), createVNode("div", { class: "flex flex-col gap-2 p-4" }, [
						createVNode("div", null, [createVNode(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.kategorija.label,
							icon: __props.item.kategorija.icon
						}, null, 8, ["label", "icon"])]),
						createVNode("h3", { class: "line-clamp-2 text-lg font-semibold leading-snug text-heading" }, toDisplayString(__props.item.naslov), 1),
						createVNode("p", { class: "line-clamp-2 text-sm text-text-muted" }, toDisplayString(__props.item.opis), 1),
						createVNode("div", { class: "mt-auto flex items-center gap-1.5 pt-1 text-[13px] text-text-muted" }, [createVNode(_sfc_main$97, {
							name: "map-pin",
							size: 15
						}), createVNode("span", null, toDisplayString(__props.item.lokacija), 1)])
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$70 = _sfc_main$70.setup;
_sfc_main$70.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/cards/BusinessCard.vue");
	return _sfc_setup$70 ? _sfc_setup$70(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/BusinessProfile.vue
var BusinessProfile_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$69 });
var _sfc_main$69 = {
	__name: "BusinessProfile",
	__ssrInlineRender: true,
	props: {
		slug: {
			type: String,
			default: ""
		},
		biznis: {
			type: Object,
			default: null
		},
		slicni: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const biznis = computed(() => props.biznis);
		const slicni = computed(() => props.slicni);
		const infoItems = computed(() => {
			if (!biznis.value) return [];
			const k = biznis.value.kontakt || {};
			const items = [];
			if (k.telefon) items.push({
				icon: "phone",
				label: "Telefon",
				value: k.telefon,
				href: `tel:${k.telefon.replace(/[^0-9+]/g, "")}`
			});
			if (k.email) items.push({
				icon: "mail",
				label: "E-mail",
				value: k.email,
				href: `mailto:${k.email}`
			});
			if (k.web) items.push({
				icon: "globe",
				label: "Web",
				value: k.web,
				href: k.web.startsWith("http") ? k.web : `https://${k.web}`
			});
			if (k.radnoVrijeme) items.push({
				icon: "clock",
				label: "Radno vrijeme",
				value: k.radnoVrijeme
			});
			if (k.adresa) items.push({
				icon: "map-pin",
				label: "Adresa",
				value: k.adresa
			});
			return items;
		});
		const upitPoslan = ref(false);
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "py-8"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!biznis.value) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Biznis nije pronađen",
						text: "Traženi biznis ne postoji ili je uklonjen."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/domace-je-najbolje"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Nazad na ponudu `);
									else return [createTextVNode(" Nazad na ponudu ")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/domace-je-najbolje"
							}, {
								default: withCtx(() => [createTextVNode(" Nazad na ponudu ")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Domaće je najbolje",
								to: "/domace-je-najbolje"
							},
							{ label: biznis.value.naslov }
						] }, null, _parent, _scopeId));
						_push(`<div class="mt-6 overflow-hidden rounded-lg"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: biznis.value.kategorija?.label,
							title: biznis.value.naslov,
							subtitle: biznis.value.opis,
							image: biznis.value.slika
						}, null, _parent, _scopeId));
						_push(`</div>`);
						if (biznis.value.galerija?.length) {
							_push(`<section class="mt-10"${_scopeId}><h2 class="mb-4 font-heading text-2xl font-bold text-heading"${_scopeId}>Galerija</h2>`);
							_push(ssrRenderComponent(_sfc_main$73, { items: biznis.value.galerija }, null, _parent, _scopeId));
							_push(`</section>`);
						} else _push(`<!---->`);
						_push(`<div class="mt-10 grid gap-8 lg:grid-cols-3"${_scopeId}><div class="lg:col-span-2"${_scopeId}><h2 class="mb-4 font-heading text-2xl font-bold text-heading"${_scopeId}>O ponudi</h2><p class="whitespace-pre-line leading-relaxed text-text"${_scopeId}>${ssrInterpolate(biznis.value.opisDug)}</p></div><div class="space-y-6"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$91, {
							title: "Kontakt",
							items: infoItems.value
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(ssrRenderComponent(_sfc_main$93, {
										variant: "primary",
										icon: "send",
										block: "",
										onClick: ($event) => upitPoslan.value = true
									}, {
										default: withCtx((_, _push, _parent, _scopeId) => {
											if (_push) _push(` Pošalji upit `);
											else return [createTextVNode(" Pošalji upit ")];
										}),
										_: 1
									}, _parent, _scopeId));
									if (upitPoslan.value) _push(ssrRenderComponent(_sfc_main$86, {
										variant: "info",
										class: "mt-4",
										text: "Kontaktirajte ponuđača direktno putem navedenih podataka."
									}, null, _parent, _scopeId));
									else _push(`<!---->`);
								} else return [createVNode(_sfc_main$93, {
									variant: "primary",
									icon: "send",
									block: "",
									onClick: ($event) => upitPoslan.value = true
								}, {
									default: withCtx(() => [createTextVNode(" Pošalji upit ")]),
									_: 1
								}, 8, ["onClick"]), upitPoslan.value ? (openBlock(), createBlock(_sfc_main$86, {
									key: 0,
									variant: "info",
									class: "mt-4",
									text: "Kontaktirajte ponuđača direktno putem navedenih podataka."
								})) : createCommentVNode("", true)];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$72, { label: biznis.value.lokacija }, null, _parent, _scopeId));
						_push(`</div></div>`);
						if (slicni.value.length) _push(ssrRenderComponent(_sfc_main$89, { title: "Slično" }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(slicni.value, (b) => {
										_push(ssrRenderComponent(_sfc_main$70, {
											key: b.slug,
											item: b
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (b) => {
									return openBlock(), createBlock(_sfc_main$70, {
										key: b.slug,
										item: b
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!biznis.value ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Biznis nije pronađen",
						text: "Traženi biznis ne postoji ili je uklonjen."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "arrow-left",
							to: "/domace-je-najbolje"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na ponudu ")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [
						createVNode(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Domaće je najbolje",
								to: "/domace-je-najbolje"
							},
							{ label: biznis.value.naslov }
						] }, null, 8, ["items"]),
						createVNode("div", { class: "mt-6 overflow-hidden rounded-lg" }, [createVNode(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: biznis.value.kategorija?.label,
							title: biznis.value.naslov,
							subtitle: biznis.value.opis,
							image: biznis.value.slika
						}, null, 8, [
							"kicker",
							"title",
							"subtitle",
							"image"
						])]),
						biznis.value.galerija?.length ? (openBlock(), createBlock("section", {
							key: 0,
							class: "mt-10"
						}, [createVNode("h2", { class: "mb-4 font-heading text-2xl font-bold text-heading" }, "Galerija"), createVNode(_sfc_main$73, { items: biznis.value.galerija }, null, 8, ["items"])])) : createCommentVNode("", true),
						createVNode("div", { class: "mt-10 grid gap-8 lg:grid-cols-3" }, [createVNode("div", { class: "lg:col-span-2" }, [createVNode("h2", { class: "mb-4 font-heading text-2xl font-bold text-heading" }, "O ponudi"), createVNode("p", { class: "whitespace-pre-line leading-relaxed text-text" }, toDisplayString(biznis.value.opisDug), 1)]), createVNode("div", { class: "space-y-6" }, [createVNode(_sfc_main$91, {
							title: "Kontakt",
							items: infoItems.value
						}, {
							default: withCtx(() => [createVNode(_sfc_main$93, {
								variant: "primary",
								icon: "send",
								block: "",
								onClick: ($event) => upitPoslan.value = true
							}, {
								default: withCtx(() => [createTextVNode(" Pošalji upit ")]),
								_: 1
							}, 8, ["onClick"]), upitPoslan.value ? (openBlock(), createBlock(_sfc_main$86, {
								key: 0,
								variant: "info",
								class: "mt-4",
								text: "Kontaktirajte ponuđača direktno putem navedenih podataka."
							})) : createCommentVNode("", true)]),
							_: 1
						}, 8, ["items"]), createVNode(_sfc_main$72, { label: biznis.value.lokacija }, null, 8, ["label"])])]),
						slicni.value.length ? (openBlock(), createBlock(_sfc_main$89, {
							key: 1,
							title: "Slično"
						}, {
							default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (b) => {
								return openBlock(), createBlock(_sfc_main$70, {
									key: b.slug,
									item: b
								}, null, 8, ["item"]);
							}), 128))]),
							_: 1
						})) : createCommentVNode("", true)
					], 64))];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$69 = _sfc_main$69.setup;
_sfc_main$69.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/BusinessProfile.vue");
	return _sfc_setup$69 ? _sfc_setup$69(props, ctx) : void 0;
};
//#endregion
//#region resources/js/constants/navigation.js
var mainNav = [
	{
		label: "Domaće je najbolje",
		to: "/domace-je-najbolje",
		children: [
			{
				label: "Zanatski proizvodi",
				to: "/domace-je-najbolje?kategorija=zanat"
			},
			{
				label: "Domaća hrana i piće",
				to: "/domace-je-najbolje?kategorija=hrana"
			},
			{
				label: "Usluge i servisi",
				to: "/domace-je-najbolje?kategorija=usluge"
			}
		]
	},
	{
		label: "Turizam",
		to: "/turizam",
		children: [
			{
				label: "Prirodne atrakcije",
				to: "/turizam?kategorija=priroda"
			},
			{
				label: "Kulturne manifestacije",
				to: "/turizam?kategorija=kultura"
			},
			{
				label: "Planine, šume i sela",
				to: "/turizam?kategorija=planine"
			},
			{
				label: "Gdje odsjesti",
				to: "/turizam?kategorija=smjestaj"
			}
		]
	},
	{
		label: "Događaji",
		to: "/dogadjaji"
	},
	{
		label: "Oglasi",
		to: "/oglasi"
	},
	{
		label: "Mapa",
		to: "/mapa"
	},
	{
		label: "Priče",
		to: "/price",
		children: [
			{
				label: "Domaćini pričaju",
				to: "/price?kategorija=domacini"
			},
			{
				label: "Ljudi i biznisi",
				to: "/price?kategorija=ljudi"
			},
			{
				label: "Naša svakodnevica",
				to: "/price?kategorija=svakodnevica"
			}
		]
	}
];
var secondaryNav = [{
	label: "O projektu",
	to: "/o-projektu"
}, {
	label: "Kontakt",
	to: "/kontakt"
}];
var footerLinks = {
	brzi: [
		{
			label: "Početna",
			to: "/"
		},
		{
			label: "O projektu",
			to: "/o-projektu"
		},
		{
			label: "Događaji",
			to: "/dogadjaji"
		},
		{
			label: "Pridruži se",
			to: "/pridruzi-se"
		}
	],
	istrazi: [
		{
			label: "Domaće je najbolje",
			to: "/domace-je-najbolje"
		},
		{
			label: "Turizam",
			to: "/turizam"
		},
		{
			label: "Mapa ponude",
			to: "/mapa"
		},
		{
			label: "Priče",
			to: "/price"
		}
	],
	pravno: [
		{
			label: "Politika privatnosti",
			to: "/politika-privatnosti"
		},
		{
			label: "Politika kolačića",
			to: "/politika-kolacica"
		},
		{
			label: "Uslovi korištenja",
			to: "/uslovi-koristenja"
		}
	]
};
var kontakt = {
	adresa: "Svetog Save 15, 74270 Teslić",
	telefon: "053/430-058",
	email: "turistorg.teslic@gmail.com"
};
//#endregion
//#region resources/js/composables/useSite.js
function useSite() {
	const page = usePage();
	const site = computed(() => page.props.site || {});
	return {
		mainNav: computed(() => site.value.mainNav ?? mainNav),
		secondaryNav: computed(() => site.value.secondaryNav ?? secondaryNav),
		footerLinks: computed(() => site.value.footerLinks ?? footerLinks),
		kontakt: computed(() => site.value.kontakt ?? kontakt),
		postavke: computed(() => site.value.postavke ?? {})
	};
}
//#endregion
//#region resources/js/components/forms/FormField.vue
var _sfc_main$68 = {
	__name: "FormField",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({
		label: {
			type: String,
			default: ""
		},
		type: {
			type: String,
			default: "text"
		},
		placeholder: {
			type: String,
			default: ""
		},
		helper: {
			type: String,
			default: ""
		},
		error: {
			type: String,
			default: ""
		},
		required: {
			type: Boolean,
			default: false
		},
		disabled: {
			type: Boolean,
			default: false
		}
	}, {
		"modelValue": {
			type: [String, Number],
			default: ""
		},
		"modelModifiers": {}
	}),
	emits: ["update:modelValue"],
	setup(__props) {
		const model = useModel(__props, "modelValue");
		const id = useId();
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col gap-1.5" }, _attrs))}>`);
			if (__props.label) {
				_push(`<label${ssrRenderAttr("for", unref(id))} class="text-sm font-semibold text-heading">${ssrInterpolate(__props.label)} `);
				if (__props.required) _push(`<span class="text-error">*</span>`);
				else _push(`<!---->`);
				_push(`</label>`);
			} else _push(`<!---->`);
			_push(`<input${ssrRenderAttr("id", unref(id))}${ssrRenderDynamicModel(__props.type, model.value, null)}${ssrRenderAttr("type", __props.type)}${ssrRenderAttr("placeholder", __props.placeholder)}${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""}${ssrRenderAttr("aria-invalid", __props.error ? "true" : void 0)}${ssrRenderAttr("aria-describedby", __props.error || __props.helper ? `${unref(id)}-help` : void 0)} class="${ssrRenderClass([__props.error ? "border-error focus:border-error" : "border-border", "h-11 rounded-sm border bg-surface px-4 text-text outline-none transition-colors placeholder:text-text-muted focus:border-primary disabled:bg-surface-alt disabled:opacity-60"])}">`);
			if (__props.error) _push(`<p${ssrRenderAttr("id", `${unref(id)}-help`)} class="text-[13px] text-error">${ssrInterpolate(__props.error)}</p>`);
			else if (__props.helper) _push(`<p${ssrRenderAttr("id", `${unref(id)}-help`)} class="text-[13px] text-text-muted">${ssrInterpolate(__props.helper)}</p>`);
			else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$68 = _sfc_main$68.setup;
_sfc_main$68.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/forms/FormField.vue");
	return _sfc_setup$68 ? _sfc_setup$68(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/forms/FormTextarea.vue
var _sfc_main$67 = {
	__name: "FormTextarea",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({
		label: {
			type: String,
			default: ""
		},
		placeholder: {
			type: String,
			default: ""
		},
		helper: {
			type: String,
			default: ""
		},
		error: {
			type: String,
			default: ""
		},
		required: {
			type: Boolean,
			default: false
		},
		disabled: {
			type: Boolean,
			default: false
		},
		maxlength: {
			type: Number,
			default: null
		},
		rows: {
			type: Number,
			default: 5
		}
	}, {
		"modelValue": {
			type: String,
			default: ""
		},
		"modelModifiers": {}
	}),
	emits: ["update:modelValue"],
	setup(__props) {
		const model = useModel(__props, "modelValue");
		const props = __props;
		const id = useId();
		const counter = computed(() => props.maxlength ? `${model.value.length}/${props.maxlength} znakova` : "");
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col gap-1.5" }, _attrs))}>`);
			if (__props.label) {
				_push(`<label${ssrRenderAttr("for", unref(id))} class="text-sm font-semibold text-heading">${ssrInterpolate(__props.label)} `);
				if (__props.required) _push(`<span class="text-error">*</span>`);
				else _push(`<!---->`);
				_push(`</label>`);
			} else _push(`<!---->`);
			_push(`<textarea${ssrRenderAttr("id", unref(id))}${ssrRenderAttr("rows", __props.rows)}${ssrRenderAttr("placeholder", __props.placeholder)}${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""}${ssrRenderAttr("maxlength", __props.maxlength || void 0)}${ssrRenderAttr("aria-invalid", __props.error ? "true" : void 0)} class="${ssrRenderClass([__props.error ? "border-error" : "border-border", "resize-y rounded-sm border bg-surface px-4 py-3 text-text outline-none transition-colors placeholder:text-text-muted focus:border-primary disabled:bg-surface-alt disabled:opacity-60"])}">${ssrInterpolate(model.value)}</textarea><div class="flex justify-between gap-2">`);
			if (__props.error) _push(`<p class="text-[13px] text-error">${ssrInterpolate(__props.error)}</p>`);
			else if (__props.helper) _push(`<p class="text-[13px] text-text-muted">${ssrInterpolate(__props.helper)}</p>`);
			else _push(`<!---->`);
			if (counter.value) _push(`<p class="ml-auto text-[13px] text-text-muted">${ssrInterpolate(counter.value)}</p>`);
			else _push(`<!---->`);
			_push(`</div></div>`);
		};
	}
};
var _sfc_setup$67 = _sfc_main$67.setup;
_sfc_main$67.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/forms/FormTextarea.vue");
	return _sfc_setup$67 ? _sfc_setup$67(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/forms/FormCheckbox.vue
var _sfc_main$66 = {
	__name: "FormCheckbox",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({
		label: {
			type: String,
			default: ""
		},
		required: {
			type: Boolean,
			default: false
		},
		disabled: {
			type: Boolean,
			default: false
		}
	}, {
		"modelValue": {
			type: Boolean,
			default: false
		},
		"modelModifiers": {}
	}),
	emits: ["update:modelValue"],
	setup(__props) {
		const model = useModel(__props, "modelValue");
		const id = useId();
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<label${ssrRenderAttrs(mergeProps({
				for: unref(id),
				class: ["inline-flex cursor-pointer items-start gap-2.5 text-text", __props.disabled ? "cursor-not-allowed opacity-60" : ""]
			}, _attrs))}><span class="relative mt-0.5 inline-flex"><input${ssrRenderAttr("id", unref(id))}${ssrIncludeBooleanAttr(Array.isArray(model.value) ? ssrLooseContain(model.value, null) : model.value) ? " checked" : ""} type="checkbox"${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""} class="peer size-5 shrink-0 appearance-none rounded-sm border border-border bg-surface outline-none transition-colors checked:border-primary checked:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "check",
				size: 14,
				class: "pointer-events-none absolute left-1/2 top-1/2 hidden -translate-x-1/2 -translate-y-1/2 text-white peer-checked:block"
			}, null, _parent));
			_push(`</span><span class="text-[15px] leading-snug">`);
			ssrRenderSlot(_ctx.$slots, "default", {}, () => {
				_push(`${ssrInterpolate(__props.label)}`);
			}, _push, _parent);
			if (__props.required) _push(`<span class="text-error"> *</span>`);
			else _push(`<!---->`);
			_push(`</span></label>`);
		};
	}
};
var _sfc_setup$66 = _sfc_main$66.setup;
_sfc_main$66.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/forms/FormCheckbox.vue");
	return _sfc_setup$66 ? _sfc_setup$66(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/forms/FormCaptcha.vue
var _sfc_main$65 = {
	__name: "FormCaptcha",
	__ssrInlineRender: true,
	props: {
		"modelValue": {
			type: Boolean,
			default: false
		},
		"modelModifiers": {}
	},
	emits: ["update:modelValue"],
	setup(__props) {
		const model = useModel(__props, "modelValue");
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex h-[74px] w-[300px] items-center justify-between gap-3 rounded-sm border border-border bg-surface px-4" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$66, {
				modelValue: model.value,
				"onUpdate:modelValue": ($event) => model.value = $event,
				label: "Nisam robot"
			}, null, _parent));
			_push(`<div class="flex flex-col items-center gap-0.5 text-text-muted"><span class="text-[11px] font-semibold uppercase tracking-wide">captcha</span><span class="text-[10px]">privatnost · uslovi</span></div></div>`);
		};
	}
};
var _sfc_setup$65 = _sfc_main$65.setup;
_sfc_main$65.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/forms/FormCaptcha.vue");
	return _sfc_setup$65 ? _sfc_setup$65(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Contact.vue
var Contact_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$64 });
var _sfc_main$64 = {
	__name: "Contact",
	__ssrInlineRender: true,
	setup(__props) {
		const ime = ref("");
		const email = ref("");
		const tema = ref("");
		const poruka = ref("");
		const saglasnost = ref(false);
		const captcha = ref(false);
		const poslano = ref(false);
		const greska = ref(false);
		const { kontakt } = useSite();
		const kontaktInfo = computed(() => [
			{
				icon: "map-pin",
				label: "Adresa",
				value: kontakt.value.adresa
			},
			{
				icon: "phone",
				label: "Telefon",
				value: kontakt.value.telefon,
				href: `tel:${kontakt.value.telefon}`
			},
			{
				icon: "mail",
				label: "E-mail",
				value: kontakt.value.email,
				href: `mailto:${kontakt.value.email}`
			},
			{
				icon: "clock",
				label: "Radno vrijeme",
				value: "Pon–Pet 08:00–16:00"
			}
		]);
		function posalji() {
			greska.value = false;
			poslano.value = false;
			if (!ime.value.trim() || !email.value.trim() || !poruka.value.trim() || !saglasnost.value || !captcha.value) {
				greska.value = true;
				return;
			}
			router.post("/kontakt", {
				ime: ime.value,
				email: email.value,
				tema: tema.value,
				poruka: poruka.value
			}, {
				preserveScroll: true,
				onSuccess: () => {
					poslano.value = true;
					ime.value = "";
					email.value = "";
					tema.value = "";
					poruka.value = "";
					saglasnost.value = false;
					captcha.value = false;
				},
				onError: () => {
					greska.value = true;
				}
			});
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Kontakt" }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Kontakt" }] })];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(`<h1 class="font-heading text-3xl font-bold text-heading md:text-4xl"${_scopeId}>Kontakt</h1><p class="mt-2 max-w-2xl text-text-muted"${_scopeId}> Imate pitanje, prijedlog ili želite saradnju? Pošaljite nam poruku ili nas kontaktirajte direktno. </p>`);
					else return [createVNode("h1", { class: "font-heading text-3xl font-bold text-heading md:text-4xl" }, "Kontakt"), createVNode("p", { class: "mt-2 max-w-2xl text-text-muted" }, " Imate pitanje, prijedlog ili želite saradnju? Pošaljite nam poruku ili nas kontaktirajte direktno. ")];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="grid gap-8 lg:grid-cols-2"${_scopeId}><div${_scopeId}><h2 class="font-heading text-xl font-semibold text-heading"${_scopeId}>Pošaljite poruku</h2><form class="mt-5 space-y-4"${_scopeId}>`);
						if (poslano.value) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "uspjeh",
							title: "Poruka je poslana",
							text: "Hvala na poruci! Javit ćemo vam se u najkraćem mogućem roku."
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						if (greska.value) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "greska",
							title: "Provjerite obavezna polja",
							text: "Molimo popunite ime, e-mail i poruku te potvrdite saglasnost i captchu."
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: ime.value,
							"onUpdate:modelValue": ($event) => ime.value = $event,
							label: "Ime i prezime",
							placeholder: "npr. Marko Marković",
							required: ""
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: email.value,
							"onUpdate:modelValue": ($event) => email.value = $event,
							label: "E-mail",
							type: "email",
							placeholder: "vasa@adresa.com",
							required: ""
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: tema.value,
							"onUpdate:modelValue": ($event) => tema.value = $event,
							label: "Tema / predmet",
							placeholder: "O čemu se radi?"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: poruka.value,
							"onUpdate:modelValue": ($event) => poruka.value = $event,
							label: "Poruka",
							maxlength: 800,
							placeholder: "Vaša poruka…",
							required: ""
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$66, {
							modelValue: saglasnost.value,
							"onUpdate:modelValue": ($event) => saglasnost.value = $event,
							required: ""
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Saglasan/na sam s obradom mojih podataka radi odgovora na upit. `);
								else return [createTextVNode(" Saglasan/na sam s obradom mojih podataka radi odgovora na upit. ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$65, {
							modelValue: captcha.value,
							"onUpdate:modelValue": ($event) => captcha.value = $event
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$93, {
							type: "submit",
							variant: "primary",
							icon: "send"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Pošalji`);
								else return [createTextVNode("Pošalji")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</form></div><div class="space-y-6"${_scopeId}><div class="rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]"${_scopeId}><h2 class="font-heading text-xl font-semibold text-heading"${_scopeId}> Turistička organizacija Teslić </h2><ul class="mt-5 space-y-4"${_scopeId}><!--[-->`);
						ssrRenderList(kontaktInfo.value, (info) => {
							_push(`<li class="flex items-start gap-3"${_scopeId}><span class="mt-0.5 shrink-0 text-primary"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: info.icon,
								size: 20
							}, null, _parent, _scopeId));
							_push(`</span><div${_scopeId}><p class="text-sm font-semibold text-heading"${_scopeId}>${ssrInterpolate(info.label)}</p>`);
							if (info.href) _push(`<a${ssrRenderAttr("href", info.href)} class="text-text-muted hover:text-primary hover:underline"${_scopeId}>${ssrInterpolate(info.value)}</a>`);
							else _push(`<p class="text-text-muted"${_scopeId}>${ssrInterpolate(info.value)}</p>`);
							_push(`</div></li>`);
						});
						_push(`<!--]--></ul></div>`);
						_push(ssrRenderComponent(_sfc_main$72, {
							label: "Svetog Save 15, Teslić",
							to: "/mapa"
						}, null, _parent, _scopeId));
						_push(`</div></div>`);
					} else return [createVNode("div", { class: "grid gap-8 lg:grid-cols-2" }, [createVNode("div", null, [createVNode("h2", { class: "font-heading text-xl font-semibold text-heading" }, "Pošaljite poruku"), createVNode("form", {
						class: "mt-5 space-y-4",
						onSubmit: withModifiers(posalji, ["prevent"])
					}, [
						poslano.value ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "uspjeh",
							title: "Poruka je poslana",
							text: "Hvala na poruci! Javit ćemo vam se u najkraćem mogućem roku."
						})) : createCommentVNode("", true),
						greska.value ? (openBlock(), createBlock(_sfc_main$86, {
							key: 1,
							variant: "greska",
							title: "Provjerite obavezna polja",
							text: "Molimo popunite ime, e-mail i poruku te potvrdite saglasnost i captchu."
						})) : createCommentVNode("", true),
						createVNode(_sfc_main$68, {
							modelValue: ime.value,
							"onUpdate:modelValue": ($event) => ime.value = $event,
							label: "Ime i prezime",
							placeholder: "npr. Marko Marković",
							required: ""
						}, null, 8, ["modelValue", "onUpdate:modelValue"]),
						createVNode(_sfc_main$68, {
							modelValue: email.value,
							"onUpdate:modelValue": ($event) => email.value = $event,
							label: "E-mail",
							type: "email",
							placeholder: "vasa@adresa.com",
							required: ""
						}, null, 8, ["modelValue", "onUpdate:modelValue"]),
						createVNode(_sfc_main$68, {
							modelValue: tema.value,
							"onUpdate:modelValue": ($event) => tema.value = $event,
							label: "Tema / predmet",
							placeholder: "O čemu se radi?"
						}, null, 8, ["modelValue", "onUpdate:modelValue"]),
						createVNode(_sfc_main$67, {
							modelValue: poruka.value,
							"onUpdate:modelValue": ($event) => poruka.value = $event,
							label: "Poruka",
							maxlength: 800,
							placeholder: "Vaša poruka…",
							required: ""
						}, null, 8, ["modelValue", "onUpdate:modelValue"]),
						createVNode(_sfc_main$66, {
							modelValue: saglasnost.value,
							"onUpdate:modelValue": ($event) => saglasnost.value = $event,
							required: ""
						}, {
							default: withCtx(() => [createTextVNode(" Saglasan/na sam s obradom mojih podataka radi odgovora na upit. ")]),
							_: 1
						}, 8, ["modelValue", "onUpdate:modelValue"]),
						createVNode(_sfc_main$65, {
							modelValue: captcha.value,
							"onUpdate:modelValue": ($event) => captcha.value = $event
						}, null, 8, ["modelValue", "onUpdate:modelValue"]),
						createVNode(_sfc_main$93, {
							type: "submit",
							variant: "primary",
							icon: "send"
						}, {
							default: withCtx(() => [createTextVNode("Pošalji")]),
							_: 1
						})
					], 32)]), createVNode("div", { class: "space-y-6" }, [createVNode("div", { class: "rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]" }, [createVNode("h2", { class: "font-heading text-xl font-semibold text-heading" }, " Turistička organizacija Teslić "), createVNode("ul", { class: "mt-5 space-y-4" }, [(openBlock(true), createBlock(Fragment, null, renderList(kontaktInfo.value, (info) => {
						return openBlock(), createBlock("li", {
							key: info.label,
							class: "flex items-start gap-3"
						}, [createVNode("span", { class: "mt-0.5 shrink-0 text-primary" }, [createVNode(_sfc_main$97, {
							name: info.icon,
							size: 20
						}, null, 8, ["name"])]), createVNode("div", null, [createVNode("p", { class: "text-sm font-semibold text-heading" }, toDisplayString(info.label), 1), info.href ? (openBlock(), createBlock("a", {
							key: 0,
							href: info.href,
							class: "text-text-muted hover:text-primary hover:underline"
						}, toDisplayString(info.value), 9, ["href"])) : (openBlock(), createBlock("p", {
							key: 1,
							class: "text-text-muted"
						}, toDisplayString(info.value), 1))])]);
					}), 128))])]), createVNode(_sfc_main$72, {
						label: "Svetog Save 15, Teslić",
						to: "/mapa"
					})])])];
				}),
				_: 1
			}, _parent));
			_push(`</main>`);
		};
	}
};
var _sfc_setup$64 = _sfc_main$64.setup;
_sfc_main$64.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Contact.vue");
	return _sfc_setup$64 ? _sfc_setup$64(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/cards/LocationCard.vue
var _sfc_main$63 = {
	__name: "LocationCard",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$70, mergeProps({
				item: __props.item,
				to: `/turizam/${__props.item.slug}`
			}, _attrs), null, _parent));
		};
	}
};
var _sfc_setup$63 = _sfc_main$63.setup;
_sfc_main$63.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/cards/LocationCard.vue");
	return _sfc_setup$63 ? _sfc_setup$63(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/cards/EventCard.vue
var _sfc_main$62 = {
	__name: "EventCard",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(unref(Link), mergeProps({
				href: `/dogadjaji/${__props.item.slug}`,
				class: ["group flex flex-col overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]", __props.item.zavrseno ? "opacity-70" : ""]
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$71, {
							src: __props.item.slika,
							alt: __props.item.naslov
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<div class="absolute left-3 top-3 flex flex-col items-center rounded-sm bg-surface px-2.5 py-1.5 shadow-[var(--shadow-md)]"${_scopeId}><span class="text-xl font-bold leading-none text-primary"${_scopeId}>${ssrInterpolate(__props.item.dan)}</span><span class="mt-0.5 text-[11px] font-semibold uppercase tracking-wide text-text-muted"${_scopeId}>${ssrInterpolate(__props.item.mjesec)}</span></div>`);
									if (__props.item.zavrseno) _push(ssrRenderComponent(_sfc_main$87, {
										variant: "zavrseno",
										class: "absolute right-3 top-3"
									}, null, _parent, _scopeId));
									else _push(`<!---->`);
								} else return [createVNode("div", { class: "absolute left-3 top-3 flex flex-col items-center rounded-sm bg-surface px-2.5 py-1.5 shadow-[var(--shadow-md)]" }, [createVNode("span", { class: "text-xl font-bold leading-none text-primary" }, toDisplayString(__props.item.dan), 1), createVNode("span", { class: "mt-0.5 text-[11px] font-semibold uppercase tracking-wide text-text-muted" }, toDisplayString(__props.item.mjesec), 1)]), __props.item.zavrseno ? (openBlock(), createBlock(_sfc_main$87, {
									key: 0,
									variant: "zavrseno",
									class: "absolute right-3 top-3"
								})) : createCommentVNode("", true)];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`<div class="flex flex-col gap-2 p-4"${_scopeId}><h3 class="line-clamp-2 text-lg font-semibold leading-snug text-heading"${_scopeId}>${ssrInterpolate(__props.item.naslov)}</h3><div class="flex items-center gap-1.5 text-[13px] text-text-muted"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "clock",
							size: 15
						}, null, _parent, _scopeId));
						_push(`<span${_scopeId}>${ssrInterpolate(__props.item.vrijeme)}</span></div><div class="flex items-center gap-1.5 text-[13px] text-text-muted"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "map-pin",
							size: 15
						}, null, _parent, _scopeId));
						_push(`<span${_scopeId}>${ssrInterpolate(__props.item.lokacija)}</span></div></div>`);
					} else return [createVNode(_sfc_main$71, {
						src: __props.item.slika,
						alt: __props.item.naslov
					}, {
						default: withCtx(() => [createVNode("div", { class: "absolute left-3 top-3 flex flex-col items-center rounded-sm bg-surface px-2.5 py-1.5 shadow-[var(--shadow-md)]" }, [createVNode("span", { class: "text-xl font-bold leading-none text-primary" }, toDisplayString(__props.item.dan), 1), createVNode("span", { class: "mt-0.5 text-[11px] font-semibold uppercase tracking-wide text-text-muted" }, toDisplayString(__props.item.mjesec), 1)]), __props.item.zavrseno ? (openBlock(), createBlock(_sfc_main$87, {
							key: 0,
							variant: "zavrseno",
							class: "absolute right-3 top-3"
						})) : createCommentVNode("", true)]),
						_: 1
					}, 8, ["src", "alt"]), createVNode("div", { class: "flex flex-col gap-2 p-4" }, [
						createVNode("h3", { class: "line-clamp-2 text-lg font-semibold leading-snug text-heading" }, toDisplayString(__props.item.naslov), 1),
						createVNode("div", { class: "flex items-center gap-1.5 text-[13px] text-text-muted" }, [createVNode(_sfc_main$97, {
							name: "clock",
							size: 15
						}), createVNode("span", null, toDisplayString(__props.item.vrijeme), 1)]),
						createVNode("div", { class: "flex items-center gap-1.5 text-[13px] text-text-muted" }, [createVNode(_sfc_main$97, {
							name: "map-pin",
							size: 15
						}), createVNode("span", null, toDisplayString(__props.item.lokacija), 1)])
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$62 = _sfc_main$62.setup;
_sfc_main$62.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/cards/EventCard.vue");
	return _sfc_setup$62 ? _sfc_setup$62(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/cards/StoryCard.vue
var _sfc_main$61 = {
	__name: "StoryCard",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(unref(Link), mergeProps({
				href: `/price/${__props.item.slug}`,
				class: "group flex flex-col overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)] transition-shadow hover:shadow-[var(--shadow-md)]"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$71, {
							src: __props.item.slika,
							alt: __props.item.naslov
						}, null, _parent, _scopeId));
						_push(`<div class="flex flex-col gap-2 p-4"${_scopeId}><div${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.kategorija.label,
							icon: __props.item.kategorija.icon
						}, null, _parent, _scopeId));
						_push(`</div><h3 class="line-clamp-2 text-lg font-semibold leading-snug text-heading"${_scopeId}>${ssrInterpolate(__props.item.naslov)}</h3><div class="flex items-center gap-2"${_scopeId}><span class="flex size-6 items-center justify-center rounded-full bg-primary-tint-2 text-primary"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "user",
							size: 14
						}, null, _parent, _scopeId));
						_push(`</span><span class="text-[13px] text-text-muted"${_scopeId}>${ssrInterpolate(__props.item.autor)} · ${ssrInterpolate(__props.item.datum)}</span></div><p class="line-clamp-2 text-sm text-text-muted"${_scopeId}>${ssrInterpolate(__props.item.izvod)}</p></div>`);
					} else return [createVNode(_sfc_main$71, {
						src: __props.item.slika,
						alt: __props.item.naslov
					}, null, 8, ["src", "alt"]), createVNode("div", { class: "flex flex-col gap-2 p-4" }, [
						createVNode("div", null, [createVNode(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.kategorija.label,
							icon: __props.item.kategorija.icon
						}, null, 8, ["label", "icon"])]),
						createVNode("h3", { class: "line-clamp-2 text-lg font-semibold leading-snug text-heading" }, toDisplayString(__props.item.naslov), 1),
						createVNode("div", { class: "flex items-center gap-2" }, [createVNode("span", { class: "flex size-6 items-center justify-center rounded-full bg-primary-tint-2 text-primary" }, [createVNode(_sfc_main$97, {
							name: "user",
							size: 14
						})]), createVNode("span", { class: "text-[13px] text-text-muted" }, toDisplayString(__props.item.autor) + " · " + toDisplayString(__props.item.datum), 1)]),
						createVNode("p", { class: "line-clamp-2 text-sm text-text-muted" }, toDisplayString(__props.item.izvod), 1)
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$61 = _sfc_main$61.setup;
_sfc_main$61.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/cards/StoryCard.vue");
	return _sfc_setup$61 ? _sfc_setup$61(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/cards/StoryFeaturedCard.vue
var _sfc_main$60 = {
	__name: "StoryFeaturedCard",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(unref(Link), mergeProps({
				href: `/price/${__props.item.slug}`,
				class: "group grid overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-md)] transition-shadow hover:shadow-[var(--shadow-lg)] sm:grid-cols-[280px_1fr]"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="relative aspect-[16/10] overflow-hidden bg-primary-tint sm:aspect-auto sm:min-h-56"${_scopeId}>`);
						if (__props.item.slika) _push(`<img${ssrRenderAttr("src", __props.item.slika)}${ssrRenderAttr("alt", __props.item.naslov)} loading="lazy" class="size-full object-cover transition-transform duration-300 group-hover:scale-105"${_scopeId}>`);
						else {
							_push(`<div class="flex size-full items-center justify-center text-primary-tint-2"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: "image",
								size: 44
							}, null, _parent, _scopeId));
							_push(`</div>`);
						}
						_push(`</div><div class="flex flex-col justify-center gap-3 p-6"${_scopeId}><div${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.kategorija.label,
							icon: __props.item.kategorija.icon
						}, null, _parent, _scopeId));
						_push(`</div><h3 class="text-2xl font-bold leading-tight text-heading"${_scopeId}>${ssrInterpolate(__props.item.naslov)}</h3><div class="flex items-center gap-2"${_scopeId}><span class="flex size-6 items-center justify-center rounded-full bg-primary-tint-2 text-primary"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "user",
							size: 14
						}, null, _parent, _scopeId));
						_push(`</span><span class="text-[13px] text-text-muted"${_scopeId}>${ssrInterpolate(__props.item.autor)} · ${ssrInterpolate(__props.item.datum)}</span></div><p class="text-text"${_scopeId}>${ssrInterpolate(__props.item.izvod)}</p></div>`);
					} else return [createVNode("div", { class: "relative aspect-[16/10] overflow-hidden bg-primary-tint sm:aspect-auto sm:min-h-56" }, [__props.item.slika ? (openBlock(), createBlock("img", {
						key: 0,
						src: __props.item.slika,
						alt: __props.item.naslov,
						loading: "lazy",
						class: "size-full object-cover transition-transform duration-300 group-hover:scale-105"
					}, null, 8, ["src", "alt"])) : (openBlock(), createBlock("div", {
						key: 1,
						class: "flex size-full items-center justify-center text-primary-tint-2"
					}, [createVNode(_sfc_main$97, {
						name: "image",
						size: 44
					})]))]), createVNode("div", { class: "flex flex-col justify-center gap-3 p-6" }, [
						createVNode("div", null, [createVNode(_sfc_main$88, {
							variant: "kategorija",
							label: __props.item.kategorija.label,
							icon: __props.item.kategorija.icon
						}, null, 8, ["label", "icon"])]),
						createVNode("h3", { class: "text-2xl font-bold leading-tight text-heading" }, toDisplayString(__props.item.naslov), 1),
						createVNode("div", { class: "flex items-center gap-2" }, [createVNode("span", { class: "flex size-6 items-center justify-center rounded-full bg-primary-tint-2 text-primary" }, [createVNode(_sfc_main$97, {
							name: "user",
							size: 14
						})]), createVNode("span", { class: "text-[13px] text-text-muted" }, toDisplayString(__props.item.autor) + " · " + toDisplayString(__props.item.datum), 1)]),
						createVNode("p", { class: "text-text" }, toDisplayString(__props.item.izvod), 1)
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$60 = _sfc_main$60.setup;
_sfc_main$60.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/cards/StoryFeaturedCard.vue");
	return _sfc_setup$60 ? _sfc_setup$60(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/Stepper.vue
var _sfc_main$59 = {
	__name: "Stepper",
	__ssrInlineRender: true,
	props: { steps: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<ol${ssrRenderAttrs(mergeProps({ class: "flex flex-col gap-6 md:flex-row md:gap-0" }, _attrs))}><!--[-->`);
			ssrRenderList(__props.steps, (step, i) => {
				_push(`<li class="relative flex gap-4 md:flex-1 md:flex-col md:gap-4">`);
				if (i < __props.steps.length - 1) _push(`<span class="absolute left-5 top-12 h-[calc(100%-0.5rem)] w-px bg-border md:left-auto md:top-5 md:h-px md:w-full md:translate-x-5" aria-hidden="true"></span>`);
				else _push(`<!---->`);
				_push(`<span class="relative z-10 flex size-10 shrink-0 items-center justify-center rounded-full bg-primary font-semibold text-white">${ssrInterpolate(i + 1)}</span><div class="md:pr-6"><h3 class="font-heading font-semibold text-heading">${ssrInterpolate(step.title)}</h3>`);
				if (step.text) _push(`<p class="mt-1 text-sm text-text-muted">${ssrInterpolate(step.text)}</p>`);
				else _push(`<!---->`);
				_push(`</div></li>`);
			});
			_push(`<!--]--></ol>`);
		};
	}
};
var _sfc_setup$59 = _sfc_main$59.setup;
_sfc_main$59.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/Stepper.vue");
	return _sfc_setup$59 ? _sfc_setup$59(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/VideoPlayer.vue
var _sfc_main$58 = {
	__name: "VideoPlayer",
	__ssrInlineRender: true,
	props: {
		src: {
			type: String,
			default: ""
		},
		poster: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "overflow-hidden rounded-md bg-primary-tint" }, _attrs))}>`);
			if (__props.src) _push(`<video${ssrRenderAttr("src", __props.src)}${ssrRenderAttr("poster", __props.poster || void 0)} controls preload="metadata" class="aspect-video size-full bg-black object-contain"></video>`);
			else {
				_push(`<div class="flex aspect-video flex-col items-center justify-center gap-2 text-primary-tint-2">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: "play",
					size: 40
				}, null, _parent));
				_push(`<span class="text-sm font-medium">Video</span></div>`);
			}
			_push(`</div>`);
		};
	}
};
var _sfc_setup$58 = _sfc_main$58.setup;
_sfc_main$58.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/VideoPlayer.vue");
	return _sfc_setup$58 ? _sfc_setup$58(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/AuthorBlock.vue
var _sfc_main$57 = {
	__name: "AuthorBlock",
	__ssrInlineRender: true,
	props: {
		author: {
			type: Object,
			required: true
		},
		to: {
			type: [String, Object],
			default: null
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "rounded-md bg-surface-alt p-5 md:p-6" }, _attrs))}><div class="flex flex-col gap-4 sm:flex-row sm:items-start">`);
			if (__props.author.avatar) _push(`<img${ssrRenderAttr("src", __props.author.avatar)}${ssrRenderAttr("alt", __props.author.ime)} class="size-14 shrink-0 rounded-full object-cover">`);
			else {
				_push(`<span class="flex size-14 shrink-0 items-center justify-center rounded-full bg-primary-tint-2 text-primary" aria-hidden="true">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: "user",
					size: 28
				}, null, _parent));
				_push(`</span>`);
			}
			_push(`<div class="min-w-0"><p class="font-heading font-semibold text-heading">${ssrInterpolate(__props.author.ime)}</p>`);
			if (__props.author.bio) _push(`<p class="mt-1 text-sm text-text-muted">${ssrInterpolate(__props.author.bio)}</p>`);
			else _push(`<!---->`);
			if (__props.to) _push(ssrRenderComponent(_sfc_main$93, {
				variant: "ghost",
				size: "sm",
				icon: "arrow-right",
				"icon-position": "right",
				to: __props.to,
				class: "mt-3 -ml-4"
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(` Sve priče autora `);
					else return [createTextVNode(" Sve priče autora ")];
				}),
				_: 1
			}, _parent));
			else _push(`<!---->`);
			_push(`</div></div></div>`);
		};
	}
};
var _sfc_setup$57 = _sfc_main$57.setup;
_sfc_main$57.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/AuthorBlock.vue");
	return _sfc_setup$57 ? _sfc_setup$57(props, ctx) : void 0;
};
//#endregion
//#region resources/js/constants/categories.js
var categories = [
	{
		key: "zanat",
		label: "Zanatski proizvodi",
		icon: "zanat"
	},
	{
		key: "hrana",
		label: "Hrana i piće",
		icon: "hrana"
	},
	{
		key: "usluge",
		label: "Usluge i servisi",
		icon: "usluge"
	},
	{
		key: "priroda",
		label: "Prirodne atrakcije",
		icon: "priroda"
	},
	{
		key: "kultura",
		label: "Kultura",
		icon: "kultura"
	},
	{
		key: "smjestaj",
		label: "Smještaj",
		icon: "smjestaj"
	},
	{
		key: "dogadjaj",
		label: "Događaji",
		icon: "dogadjaj"
	}
];
var categoryByKey = Object.fromEntries(categories.map((c) => [c.key, c]));
//#endregion
//#region resources/js/components/map/markerIcon.js
var categoryColors = {
	zanat: "#E88828",
	hrana: "#0E8275",
	usluge: "#1C68B5",
	priroda: "#1E7D3C",
	kultura: "#8C5810",
	smjestaj: "#0A645A",
	dogadjaj: "#C8D848"
};
var darkSymbol = /* @__PURE__ */ new Set(["dogadjaj"]);
var DEFAULT_COLOR = "#5C6573";
function categoryColor(categoryKey) {
	return categoryColors[categoryKey] || DEFAULT_COLOR;
}
function categoryIcon(L, categoryKey) {
	const color = categoryColor(categoryKey);
	const html = `
    <span class="map-pin-marker" style="--pin-color:${color}">
      <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M16 0C7.163 0 0 7.163 0 16c0 10.5 16 24 16 24s16-13.5 16-24C32 7.163 24.837 0 16 0z" fill="${color}"/>
        <circle cx="16" cy="16" r="6" fill="${darkSymbol.has(categoryKey) ? "#12151C" : "#FFFFFF"}"/>
      </svg>
    </span>
  `;
	return L.divIcon({
		html,
		className: "map-pin-divicon",
		iconSize: [32, 40],
		iconAnchor: [16, 40],
		popupAnchor: [0, -38]
	});
}
//#endregion
//#region resources/js/components/map/MapInteractive.vue
var _sfc_main$56 = {
	__name: "MapInteractive",
	__ssrInlineRender: true,
	props: {
		items: {
			type: Array,
			default: () => []
		},
		activeCategories: {
			type: Array,
			default: () => []
		},
		center: {
			type: Array,
			default: () => [44.6078, 17.8569]
		},
		zoom: {
			type: Number,
			default: 13
		},
		height: {
			type: String,
			default: "520px"
		}
	},
	emits: ["select"],
	setup(__props, { emit: __emit }) {
		let L = null;
		const props = __props;
		const emit = __emit;
		const mapEl = ref(null);
		let map = null;
		let clusterGroup = null;
		function escapeHtml(value) {
			return String(value ?? "").replace(/[&<>"']/g, (c) => ({
				"&": "&amp;",
				"<": "&lt;",
				">": "&gt;",
				"\"": "&quot;",
				"'": "&#39;"
			})[c]);
		}
		function isVisible(item) {
			if (!props.activeCategories || props.activeCategories.length === 0) return true;
			return props.activeCategories.includes(item.kategorija);
		}
		function popupHtml(item) {
			const cat = categoryByKey[item.kategorija];
			return `
    <div class="map-popup-basic">
      <strong>${escapeHtml(item.naslov)}</strong>
      <span>${escapeHtml(cat?.label || item.kategorija)}</span>
    </div>
  `;
		}
		function drawMarkers() {
			if (!clusterGroup || !L) return;
			clusterGroup.clearLayers();
			props.items.filter(isVisible).forEach((item) => {
				if (item.lat == null || item.lng == null) return;
				const marker = L.marker([item.lat, item.lng], {
					icon: categoryIcon(L, item.kategorija),
					title: item.naslov
				});
				marker.bindPopup(popupHtml(item));
				marker.on("click", () => emit("select", item));
				clusterGroup.addLayer(marker);
			});
		}
		onMounted(async () => {
			L = (await import("leaflet")).default;
			await import("leaflet.markercluster");
			await Promise.resolve({                   });
			await Promise.resolve({                         });
			await Promise.resolve({                                 });
			map = L.map(mapEl.value, {
				center: props.center,
				zoom: props.zoom,
				scrollWheelZoom: true
			});
			L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
				attribution: "&copy; OpenStreetMap",
				maxZoom: 19
			}).addTo(map);
			clusterGroup = L.markerClusterGroup({ showCoverageOnHover: false });
			map.addLayer(clusterGroup);
			drawMarkers();
			nextTick(() => map && map.invalidateSize());
		});
		onUnmounted(() => {
			if (map) {
				map.remove();
				map = null;
				clusterGroup = null;
			}
		});
		watch(() => props.items, drawMarkers, { deep: true });
		watch(() => props.activeCategories, drawMarkers, { deep: true });
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({
				ref_key: "mapEl",
				ref: mapEl,
				class: "z-0 w-full overflow-hidden rounded-md",
				style: { height: __props.height },
				role: "application",
				"aria-label": "Interaktivna mapa ponude"
			}, _attrs))} data-v-94014609></div>`);
		};
	}
};
var _sfc_setup$56 = _sfc_main$56.setup;
_sfc_main$56.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/map/MapInteractive.vue");
	return _sfc_setup$56 ? _sfc_setup$56(props, ctx) : void 0;
};
var MapInteractive_default = /*#__PURE__*/ _plugin_vue_export_helper_default(_sfc_main$56, [["__scopeId", "data-v-94014609"]]);
//#endregion
//#region resources/js/components/map/MapFilterPanel.vue
var _sfc_main$55 = {
	__name: "MapFilterPanel",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({ categories: {
		type: Array,
		default: () => categories
	} }, {
		"modelValue": {
			type: Array,
			default: () => []
		},
		"modelModifiers": {}
	}),
	emits: /*@__PURE__*/ mergeModels(["search"], ["update:modelValue"]),
	setup(__props, { emit: __emit }) {
		const model = useModel(__props, "modelValue");
		const emit = __emit;
		const query = ref("");
		function onSearch(value) {
			emit("search", value);
		}
		function isChecked(key) {
			return model.value.includes(key);
		}
		function toggle(key, checked) {
			if (checked) {
				if (!model.value.includes(key)) model.value = [...model.value, key];
			} else model.value = model.value.filter((k) => k !== key);
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "space-y-5 rounded-md border border-border bg-surface p-4" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$79, {
				modelValue: query.value,
				"onUpdate:modelValue": ($event) => query.value = $event,
				placeholder: "Pretraži ponudu…",
				onSubmit: onSearch
			}, null, _parent));
			_push(`<div class="space-y-3"><h3 class="text-sm font-semibold text-heading">Slojevi</h3><ul class="space-y-2.5"><!--[-->`);
			ssrRenderList(__props.categories, (cat) => {
				_push(`<li>`);
				_push(ssrRenderComponent(_sfc_main$66, {
					"model-value": isChecked(cat.key),
					label: cat.label,
					"onUpdate:modelValue": (v) => toggle(cat.key, v)
				}, null, _parent));
				_push(`</li>`);
			});
			_push(`<!--]--></ul></div><div class="space-y-2.5 border-t border-border pt-4"><h3 class="text-sm font-semibold text-heading">Legenda</h3><ul class="grid grid-cols-2 gap-x-3 gap-y-2"><!--[-->`);
			ssrRenderList(__props.categories, (cat) => {
				_push(`<li class="flex items-center gap-2 text-sm text-text"><span class="${ssrRenderClass([cat.key === "dogadjaj" ? "text-heading" : "text-white", "inline-flex size-6 shrink-0 items-center justify-center rounded-full"])}" style="${ssrRenderStyle({ backgroundColor: unref(categoryColor)(cat.key) })}">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: cat.icon,
					size: 14
				}, null, _parent));
				_push(`</span><span class="truncate">${ssrInterpolate(cat.label)}</span></li>`);
			});
			_push(`<!--]--></ul></div></div>`);
		};
	}
};
var _sfc_setup$55 = _sfc_main$55.setup;
_sfc_main$55.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/map/MapFilterPanel.vue");
	return _sfc_setup$55 ? _sfc_setup$55(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/map/ResultsList.vue
var _sfc_main$54 = {
	__name: "ResultsList",
	__ssrInlineRender: true,
	props: { items: {
		type: Array,
		default: () => []
	} },
	emits: ["select"],
	setup(__props) {
		function category(item) {
			return categoryByKey[item.kategorija] || null;
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "rounded-md border border-border bg-surface" }, _attrs))}><h3 class="border-b border-border px-4 py-3 text-sm font-semibold text-heading"> Rezultati (${ssrInterpolate(__props.items.length)}) </h3><ul class="max-h-[480px] divide-y divide-border overflow-y-auto"><!--[-->`);
			ssrRenderList(__props.items, (item) => {
				_push(`<li><button type="button" class="flex w-full items-center gap-3 px-4 py-3 text-left transition-colors hover:bg-surface-alt"><span class="size-12 shrink-0 overflow-hidden rounded-sm bg-primary-tint">`);
				if (item.slika) _push(`<img${ssrRenderAttr("src", item.slika)}${ssrRenderAttr("alt", item.naslov)} loading="lazy" class="size-full object-cover">`);
				else {
					_push(`<span class="${ssrRenderClass([item.kategorija === "dogadjaj" ? "text-heading" : "text-white", "flex size-full items-center justify-center"])}" style="${ssrRenderStyle({ backgroundColor: unref(categoryColor)(item.kategorija) })}">`);
					if (category(item)) _push(ssrRenderComponent(_sfc_main$97, {
						name: category(item).icon,
						size: 20
					}, null, _parent));
					else _push(`<!---->`);
					_push(`</span>`);
				}
				_push(`</span><span class="min-w-0 flex-1 space-y-1"><span class="block truncate font-semibold text-heading">${ssrInterpolate(item.naslov)}</span><span class="flex flex-wrap items-center gap-2">`);
				if (category(item)) _push(ssrRenderComponent(_sfc_main$88, {
					variant: "kategorija",
					label: category(item).label,
					icon: category(item).icon
				}, null, _parent));
				else _push(`<!---->`);
				_push(`</span>`);
				if (item.lokacija) {
					_push(`<span class="flex items-center gap-1 text-sm text-text-muted">`);
					_push(ssrRenderComponent(_sfc_main$97, {
						name: "map-pin",
						size: 14
					}, null, _parent));
					_push(`<span class="truncate">${ssrInterpolate(item.lokacija)}</span></span>`);
				} else _push(`<!---->`);
				_push(`</span></button></li>`);
			});
			_push(`<!--]--></ul>`);
			if (__props.items.length === 0) _push(`<p class="px-4 py-8 text-center text-sm text-text-muted"> Nema rezultata za prikaz. </p>`);
			else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$54 = _sfc_main$54.setup;
_sfc_main$54.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/map/ResultsList.vue");
	return _sfc_setup$54 ? _sfc_setup$54(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/map/MapPopup.vue
var _sfc_main$53 = {
	__name: "MapPopup",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	emits: ["close"],
	setup(__props) {
		const props = __props;
		const category = computed(() => categoryByKey[props.item.kategorija] || null);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "relative w-[280px] overflow-hidden rounded-md bg-surface shadow-[var(--shadow-lg)]" }, _attrs))}><button type="button" class="absolute right-2 top-2 z-10 inline-flex size-8 items-center justify-center rounded-full bg-surface/90 text-heading shadow-[var(--shadow-sm)] transition-colors hover:bg-surface-alt" aria-label="Zatvori">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "x",
				size: 18
			}, null, _parent));
			_push(`</button>`);
			_push(ssrRenderComponent(_sfc_main$71, {
				src: __props.item.slika,
				alt: __props.item.naslov
			}, null, _parent));
			_push(`<div class="space-y-2.5 p-4"><h3 class="font-semibold text-heading">${ssrInterpolate(__props.item.naslov)}</h3>`);
			if (category.value) _push(ssrRenderComponent(_sfc_main$88, {
				variant: "kategorija",
				label: category.value.label,
				icon: category.value.icon
			}, null, _parent));
			else _push(`<!---->`);
			if (__props.item.lokacija) {
				_push(`<p class="flex items-center gap-1.5 text-sm text-text-muted">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: "map-pin",
					size: 16
				}, null, _parent));
				_push(`<span>${ssrInterpolate(__props.item.lokacija)}</span></p>`);
			} else _push(`<!---->`);
			if (__props.item.to) _push(ssrRenderComponent(_sfc_main$93, {
				variant: "ghost",
				size: "sm",
				icon: "arrow-right",
				"icon-position": "right",
				to: __props.item.to
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(` Detalji `);
					else return [createTextVNode(" Detalji ")];
				}),
				_: 1
			}, _parent));
			else _push(`<!---->`);
			_push(`</div></div>`);
		};
	}
};
var _sfc_setup$53 = _sfc_main$53.setup;
_sfc_main$53.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/map/MapPopup.vue");
	return _sfc_setup$53 ? _sfc_setup$53(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/calendar/EventCalendar.vue
var _sfc_main$52 = {
	__name: "EventCalendar",
	__ssrInlineRender: true,
	props: /*@__PURE__*/ mergeModels({
		events: {
			type: Array,
			default: () => []
		},
		initialMonth: {
			type: [Date, String],
			default: null
		}
	}, {
		"modelValue": {
			type: String,
			default: ""
		},
		"modelModifiers": {}
	}),
	emits: /*@__PURE__*/ mergeModels(["selectDay"], ["update:modelValue"]),
	setup(__props, { emit: __emit }) {
		const props = __props;
		const selected = useModel(__props, "modelValue");
		const MJESECI = [
			"Januar",
			"Februar",
			"Mart",
			"April",
			"Maj",
			"Jun",
			"Jul",
			"Avgust",
			"Septembar",
			"Oktobar",
			"Novembar",
			"Decembar"
		];
		const DANI = [
			"Pon",
			"Uto",
			"Sri",
			"Čet",
			"Pet",
			"Sub",
			"Ned"
		];
		const pad = (n) => String(n).padStart(2, "0");
		const toIso = (y, m, d) => `${y}-${pad(m + 1)}-${pad(d)}`;
		function parseInitial(value) {
			if (value instanceof Date) return new Date(value.getFullYear(), value.getMonth(), 1);
			if (typeof value === "string") {
				const [y, m] = value.split("-").map(Number);
				if (y && m) return new Date(y, m - 1, 1);
			}
			const now = /* @__PURE__ */ new Date();
			return new Date(now.getFullYear(), now.getMonth(), 1);
		}
		const cursor = ref(parseInitial(props.initialMonth));
		const godina = computed(() => cursor.value.getFullYear());
		const mjesec = computed(() => cursor.value.getMonth());
		const naslov = computed(() => `${MJESECI[mjesec.value]} ${godina.value}`);
		const brojPoDanu = computed(() => {
			const map = {};
			for (const e of props.events) {
				if (!e?.date) continue;
				map[e.date] = (map[e.date] || 0) + 1;
			}
			return map;
		});
		const danasIso = computed(() => {
			const n = /* @__PURE__ */ new Date();
			return toIso(n.getFullYear(), n.getMonth(), n.getDate());
		});
		const dani = computed(() => {
			const y = godina.value;
			const m = mjesec.value;
			const offset = (new Date(y, m, 1).getDay() + 6) % 7;
			const celije = [];
			const start = new Date(y, m, 1 - offset);
			for (let i = 0; i < 42; i++) {
				const d = new Date(start.getFullYear(), start.getMonth(), start.getDate() + i);
				const iso = toIso(d.getFullYear(), d.getMonth(), d.getDate());
				celije.push({
					iso,
					broj: d.getDate(),
					uMjesecu: d.getMonth() === m,
					brojDogadjaja: brojPoDanu.value[iso] || 0
				});
			}
			return celije;
		});
		function imeMjeseca(iso) {
			return MJESECI[Number(iso.split("-")[1]) - 1];
		}
		function ariaLabel(celija) {
			const m = imeMjeseca(celija.iso);
			let label = `${celija.broj}. ${m} ${celija.iso.split("-")[0]}`;
			if (celija.iso === danasIso.value) label += ", danas";
			if (celija.brojDogadjaja > 0) label += `, ${celija.brojDogadjaja} ${celija.brojDogadjaja === 1 ? "događaj" : "događaja"}`;
			return label;
		}
		const odabranoTekst = computed(() => {
			if (!selected.value) return "";
			const [y, m, d] = selected.value.split("-");
			return `${Number(d)}. ${MJESECI[Number(m) - 1]} ${y}`;
		});
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "rounded-md border border-border bg-surface p-4 shadow-[var(--shadow-sm)] sm:p-5" }, _attrs))}><div class="mb-4 flex items-center justify-between"><button type="button" class="flex h-10 w-10 items-center justify-center rounded-sm border border-border text-text-muted transition-colors hover:bg-surface-alt" aria-label="Prethodni mjesec">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "chevron-left",
				size: 20
			}, null, _parent));
			_push(`</button><h3 class="flex items-center gap-2 font-heading text-lg font-semibold text-heading">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "calendar",
				size: 18
			}, null, _parent));
			_push(` ${ssrInterpolate(naslov.value)}</h3><button type="button" class="flex h-10 w-10 items-center justify-center rounded-sm border border-border text-text-muted transition-colors hover:bg-surface-alt" aria-label="Sljedeći mjesec">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "chevron-right",
				size: 20
			}, null, _parent));
			_push(`</button></div><div class="grid grid-cols-7 gap-1"><!--[-->`);
			ssrRenderList(DANI, (dan) => {
				_push(`<div class="py-1 text-center text-[11px] font-semibold uppercase tracking-wide text-text-muted">${ssrInterpolate(dan)}</div>`);
			});
			_push(`<!--]--></div><div class="mt-1 grid grid-cols-7 gap-1"><!--[-->`);
			ssrRenderList(dani.value, (celija) => {
				_push(`<button type="button"${ssrRenderAttr("aria-label", ariaLabel(celija))}${ssrRenderAttr("aria-pressed", selected.value === celija.iso)}${ssrRenderAttr("aria-current", celija.iso === danasIso.value ? "date" : void 0)} class="${ssrRenderClass([[selected.value === celija.iso ? "bg-primary font-semibold text-white" : celija.iso === danasIso.value ? "bg-primary-tint font-semibold text-primary hover:bg-primary-tint-2" : celija.uMjesecu ? "text-text hover:bg-surface-alt" : "text-text-muted/50 hover:bg-surface-alt"], "relative flex aspect-square min-h-[40px] flex-col items-center justify-center rounded-sm text-sm transition-colors sm:min-h-[44px]"])}"><span class="leading-none">${ssrInterpolate(celija.broj)}</span>`);
				if (celija.brojDogadjaja > 0) {
					_push(`<span class="absolute bottom-1.5 flex items-center gap-0.5" aria-hidden="true"><!--[-->`);
					ssrRenderList(Math.min(celija.brojDogadjaja, 3), (n) => {
						_push(`<span class="${ssrRenderClass([selected.value === celija.iso ? "bg-white" : "bg-primary", "h-1 w-1 rounded-pill"])}"></span>`);
					});
					_push(`<!--]--></span>`);
				} else _push(`<!---->`);
				_push(`</button>`);
			});
			_push(`<!--]--></div>`);
			if (selected.value) _push(`<p class="mt-4 text-sm text-text-muted"> Odabrano: <span class="font-semibold text-text">${ssrInterpolate(odabranoTekst.value)}</span></p>`);
			else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$52 = _sfc_main$52.setup;
_sfc_main$52.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/calendar/EventCalendar.vue");
	return _sfc_setup$52 ? _sfc_setup$52(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Dev.vue
var Dev_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$51 });
var _sfc_main$51 = {
	__name: "Dev",
	__ssrInlineRender: true,
	setup(__props) {
		const ime = ref("");
		const kat = ref("");
		const poruka = ref("");
		const saglasnost = ref(false);
		const captcha = ref(false);
		const aktivanFilter = ref("med");
		const stranica = ref(3);
		const filteri = [
			"med",
			"rakija",
			"sir"
		];
		const buttons = [
			"primary",
			"secondary",
			"ghost",
			"akcent",
			"sekundarna"
		];
		const badges = [
			"objavljeno",
			"na-odobrenju",
			"nacrt",
			"isteklo",
			"odbijeno",
			"preporuceno",
			"zavrseno"
		];
		const biznisi = [
			{
				slug: "stari-zanati-borje",
				naslov: "Stari zanati Borje",
				opis: "Tradicionalna izrada drvenih suvenira i predmeta domaće radinosti.",
				kategorija: {
					label: "Zanat",
					icon: "zanat"
				},
				lokacija: "Borje, Teslić",
				preporuceno: true
			},
			{
				slug: "pcelarstvo-vrucica",
				naslov: "Pčelarstvo Vrućica",
				opis: "Domaći med, vosak i pčelinji proizvodi sa obronaka planine Borje.",
				kategorija: {
					label: "Hrana",
					icon: "hrana"
				},
				lokacija: "Banja Vrućica"
			},
			{
				slug: "rakija-ocaus",
				naslov: "Rakija Očauš",
				opis: "Šljivovica i travarica po recepturi koja se prenosi generacijama.",
				kategorija: {
					label: "Hrana",
					icon: "hrana"
				},
				lokacija: "Očauš"
			},
			{
				slug: "servis-teslic",
				naslov: "Servis i usluge Teslić",
				opis: "Pouzdane lokalne usluge i servisi za domaćinstvo i turiste.",
				kategorija: {
					label: "Usluge",
					icon: "usluge"
				},
				lokacija: "Teslić, centar"
			}
		];
		const lokaliteti = [
			{
				slug: "planina-borja",
				naslov: "Planina Borja",
				opis: "Netaknuta priroda, planinarske staze i vidikovci nadomak grada.",
				kategorija: {
					label: "Priroda",
					icon: "priroda"
				},
				lokacija: "Borja",
				preporuceno: true
			},
			{
				slug: "banja-vrucica",
				naslov: "Banja Vrućica",
				opis: "Termalna voda i wellness ponuda jedne od najpoznatijih banja.",
				kategorija: {
					label: "Smještaj",
					icon: "smjestaj"
				},
				lokacija: "Banja Vrućica"
			},
			{
				slug: "vrh-ocaus",
				naslov: "Vrh Očauš",
				opis: "Najviši vrh Borja s panoramskim pogledom na cijeli kraj.",
				kategorija: {
					label: "Priroda",
					icon: "priroda"
				},
				lokacija: "Očauš"
			}
		];
		const dogadjaji = [
			{
				slug: "ljeto-na-borju",
				naslov: "Ljeto na Borju — festival",
				dan: "12",
				mjesec: "JUL",
				vrijeme: "18:00 — 23:00",
				lokacija: "Planina Borja"
			},
			{
				slug: "sajam-meda",
				naslov: "Sajam domaćeg meda i rakije",
				dan: "05",
				mjesec: "AVG",
				vrijeme: "10:00 — 16:00",
				lokacija: "Trg, Teslić"
			},
			{
				slug: "koncert-vrucica",
				naslov: "Ljetni koncert u Banji Vrućici",
				dan: "20",
				mjesec: "JUN",
				vrijeme: "20:00",
				lokacija: "Banja Vrućica",
				zavrseno: true
			}
		];
		const oglasi = [
			{
				slug: "konobar-kardial",
				naslov: "Traži se konobar — Banja Vrućica",
				vrsta: {
					label: "Posao",
					icon: "briefcase"
				},
				izdavac: "Hotel Kardial",
				lokacija: "Banja Vrućica",
				rok: "30.06.2026."
			},
			{
				slug: "najam-prostora",
				naslov: "Izdaje se poslovni prostor u centru",
				vrsta: {
					label: "Nekretnine",
					icon: "building-2"
				},
				izdavac: "Privatni oglašivač",
				lokacija: "Teslić, centar",
				rok: "15.07.2026."
			},
			{
				slug: "stari-oglas",
				naslov: "Sezonski berači (istekao oglas)",
				vrsta: {
					label: "Posao",
					icon: "briefcase"
				},
				izdavac: "OPG Borje",
				lokacija: "Borje",
				rok: "01.06.2026.",
				isteklo: true
			}
		];
		const price = [
			{
				slug: "pcelarska-prica-borja",
				naslov: "Kako je nastala pčelarska priča Borja",
				kategorija: {
					label: "Domaćini pričaju",
					icon: "book-open"
				},
				autor: "Marko M.",
				datum: "22.06.2026.",
				izvod: "Od nekoliko košnica do brenda — priča porodice koja živi od planine."
			},
			{
				slug: "zanatlije-teslica",
				naslov: "Zanatlije koje čuvaju tradiciju",
				kategorija: {
					label: "Ljudi i biznisi",
					icon: "book-open"
				},
				autor: "Ana K.",
				datum: "18.06.2026.",
				izvod: "Drvo, vuna i glina — majstori čiji rad postaje suvenir Teslića."
			},
			{
				slug: "svakodnevica-vrucica",
				naslov: "Jutro u Banji Vrućici",
				kategorija: {
					label: "Naša svakodnevica",
					icon: "book-open"
				},
				autor: "Redakcija",
				datum: "15.06.2026.",
				izvod: "Kako izgleda običan dan u jednom od najposjećenijih mjesta kraja."
			}
		];
		const featured = {
			slug: "ljudi-duh-teslica",
			naslov: "Ljudi koji čuvaju duh Teslića",
			kategorija: {
				label: "Izdvojeno",
				icon: "star"
			},
			autor: "Redakcija",
			datum: "20.06.2026.",
			izvod: "Priče domaćina, zanatlija i autora koji svojim radom oblikuju turističku ponudu kraja."
		};
		const prikaz = ref("lista");
		const upit = ref("");
		const filterKat = ref("");
		const aktivniFilteri = ref([{
			key: "kat",
			label: "Hrana"
		}, {
			key: "mjesto",
			label: "Borje"
		}]);
		const prikazOpcije = [{
			value: "lista",
			label: "Lista",
			icon: "list"
		}, {
			value: "kalendar",
			label: "Kalendar",
			icon: "calendar"
		}];
		const galerija = [
			{
				src: "",
				alt: "Borje 1"
			},
			{
				src: "",
				alt: "Borje 2",
				type: "video"
			},
			{
				src: "",
				alt: "Banja Vrućica"
			},
			{
				src: "",
				alt: "Očauš"
			},
			{
				src: "",
				alt: "Centar"
			},
			{
				src: "",
				alt: "Festival"
			}
		];
		const infoItems = [
			{
				icon: "map-pin",
				label: "Lokacija",
				value: "Planina Borja, Teslić"
			},
			{
				icon: "clock",
				label: "Radno vrijeme",
				value: "08:00 — 20:00"
			},
			{
				icon: "phone",
				label: "Telefon",
				value: "053/430-058",
				href: "tel:053430058"
			},
			{
				icon: "ticket",
				label: "Ulaznice",
				value: "Besplatan ulaz"
			}
		];
		const koraci = [
			{
				title: "Prijava",
				text: "Popunite formu i pošaljite prijavu biznisa ili priče."
			},
			{
				title: "Pregled",
				text: "Administrator pregleda i provjerava prijavu."
			},
			{
				title: "Objava",
				text: "Nakon odobrenja sadržaj je vidljiv posjetiocima."
			}
		];
		const autor = {
			ime: "Marko Marković",
			bio: "Lokalni autor i pčelar sa Borja koji piše o domaćinima i tradiciji kraja."
		};
		function ukloniFilter(key) {
			aktivniFilteri.value = aktivniFilteri.value.filter((c) => c.key !== key);
		}
		const aktivneKat = ref([]);
		const odabranPin = ref(null);
		const pinovi = [
			{
				slug: "banja-vrucica",
				naslov: "Banja Vrućica",
				kategorija: "smjestaj",
				lokacija: "Banja Vrućica",
				lat: 44.626,
				lng: 17.861
			},
			{
				slug: "planina-borja",
				naslov: "Planina Borja",
				kategorija: "priroda",
				lokacija: "Borje",
				lat: 44.66,
				lng: 17.79
			},
			{
				slug: "vrh-ocaus",
				naslov: "Vrh Očauš",
				kategorija: "priroda",
				lokacija: "Očauš",
				lat: 44.69,
				lng: 17.81
			},
			{
				slug: "pcelarstvo-vrucica",
				naslov: "Pčelarstvo Vrućica",
				kategorija: "hrana",
				lokacija: "Banja Vrućica",
				lat: 44.63,
				lng: 17.85
			},
			{
				slug: "stari-zanati-borje",
				naslov: "Stari zanati Borje",
				kategorija: "zanat",
				lokacija: "Borje, Teslić",
				lat: 44.652,
				lng: 17.8
			},
			{
				slug: "servis-teslic",
				naslov: "Servis i usluge Teslić",
				kategorija: "usluge",
				lokacija: "Teslić, centar",
				lat: 44.6078,
				lng: 17.8569
			}
		];
		const vidljiviPinovi = computed(() => aktivneKat.value.length === 0 ? pinovi : pinovi.filter((p) => aktivneKat.value.includes(p.kategorija)));
		const odabraniDan = ref("");
		const danEvents = ref([]);
		const kalEvents = [
			{
				slug: "ljeto-na-borju",
				naslov: "Ljeto na Borju — festival",
				date: "2026-06-12",
				vrijeme: "18:00",
				lokacija: "Planina Borja"
			},
			{
				slug: "sajam-meda",
				naslov: "Sajam domaćeg meda i rakije",
				date: "2026-06-12",
				vrijeme: "10:00",
				lokacija: "Trg"
			},
			{
				slug: "izlozba",
				naslov: "Izložba zanatlija",
				date: "2026-06-21",
				lokacija: "Galerija"
			},
			{
				slug: "koncert-vrucica",
				naslov: "Ljetni koncert",
				date: "2026-06-28",
				vrijeme: "20:00",
				lokacija: "Banja Vrućica"
			}
		];
		function onSelectDay({ events }) {
			danEvents.value = events;
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "space-y-14 py-12"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<header${_scopeId}><h1 class="text-3xl font-bold text-heading"${_scopeId}>Komponente — showcase</h1><p class="mt-1 text-text-muted"${_scopeId}> Privremena dev ruta <code${_scopeId}>/_dev</code> za vizuelnu provjeru komponenti (F2 atomi + F4 kartice/stanja). </p></header><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Dugmad</h2><div class="flex flex-wrap items-center gap-3"${_scopeId}><!--[-->`);
						ssrRenderList(buttons, (v) => {
							_push(ssrRenderComponent(_sfc_main$93, {
								key: v,
								variant: v,
								icon: "arrow-right",
								"icon-position": "right"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(v)}`);
									else return [createTextVNode(toDisplayString(v), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
						});
						_push(`<!--]--></div><div class="flex flex-wrap items-center gap-3"${_scopeId}><!--[-->`);
						ssrRenderList(buttons, (v) => {
							_push(ssrRenderComponent(_sfc_main$93, {
								key: v,
								variant: v,
								size: "sm"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(v)} sm`);
									else return [createTextVNode(toDisplayString(v) + " sm", 1)];
								}),
								_: 2
							}, _parent, _scopeId));
						});
						_push(`<!--]-->`);
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "primary",
							disabled: ""
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`disabled`);
								else return [createTextVNode("disabled")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div></section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Chip / Tag</h2><div class="flex flex-wrap items-center gap-3"${_scopeId}><!--[-->`);
						ssrRenderList(filteri, (f) => {
							_push(ssrRenderComponent(_sfc_main$88, {
								key: f,
								variant: "filter",
								label: f,
								active: aktivanFilter.value === f,
								onClick: ($event) => aktivanFilter.value = f
							}, null, _parent, _scopeId));
						});
						_push(`<!--]-->`);
						_push(ssrRenderComponent(_sfc_main$88, {
							variant: "kategorija",
							label: "Zanat",
							icon: "tag"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$88, {
							variant: "uklonjiv",
							label: "Borje"
						}, null, _parent, _scopeId));
						_push(`</div></section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Badge / Status</h2><div class="flex flex-wrap items-center gap-3"${_scopeId}><!--[-->`);
						ssrRenderList(badges, (b) => {
							_push(ssrRenderComponent(_sfc_main$87, {
								key: b,
								variant: b
							}, null, _parent, _scopeId));
						});
						_push(`<!--]--></div></section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Alert / Poruka stanja</h2><div class="grid max-w-xl gap-3"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$86, {
							variant: "uspjeh",
							title: "Prijava primljena",
							text: "Vaša prijava ide na pregled administratora."
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$86, {
							variant: "greska",
							title: "Greška",
							text: "Molimo provjerite obavezna polja."
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$86, {
							variant: "info",
							text: "Polja označena zvjezdicom su obavezna."
						}, null, _parent, _scopeId));
						_push(`</div></section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Forme</h2><div class="grid max-w-xl gap-4"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: ime.value,
							"onUpdate:modelValue": ($event) => ime.value = $event,
							label: "Ime i prezime",
							placeholder: "npr. Marko Marković",
							required: ""
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							label: "E-mail",
							type: "email",
							error: "Unesite ispravnu e-mail adresu."
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$78, {
							modelValue: kat.value,
							"onUpdate:modelValue": ($event) => kat.value = $event,
							label: "Kategorija",
							options: [
								"Zanat",
								"Hrana i piće",
								"Usluge"
							],
							required: ""
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: poruka.value,
							"onUpdate:modelValue": ($event) => poruka.value = $event,
							label: "Poruka",
							maxlength: 500,
							placeholder: "Vaša poruka…"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$66, {
							modelValue: saglasnost.value,
							"onUpdate:modelValue": ($event) => saglasnost.value = $event,
							required: ""
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Prihvatam uslove korištenja i obradu podataka `);
								else return [createTextVNode(" Prihvatam uslove korištenja i obradu podataka ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$65, {
							modelValue: captcha.value,
							"onUpdate:modelValue": ($event) => captcha.value = $event
						}, null, _parent, _scopeId));
						_push(`</div></section><hr class="border-border"${_scopeId}><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Kartica/Biznis</h2>`);
						_push(ssrRenderComponent(_sfc_main$90, null, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(biznisi, (b) => {
										_push(ssrRenderComponent(_sfc_main$70, {
											key: b.slug,
											item: b
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(biznisi, (b) => {
									return createVNode(_sfc_main$70, {
										key: b.slug,
										item: b
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Kartica/Lokalitet</h2>`);
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(lokaliteti, (l) => {
										_push(ssrRenderComponent(_sfc_main$63, {
											key: l.slug,
											item: l
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(lokaliteti, (l) => {
									return createVNode(_sfc_main$63, {
										key: l.slug,
										item: l
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Kartica/Događaj</h2>`);
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(dogadjaji, (d) => {
										_push(ssrRenderComponent(_sfc_main$62, {
											key: d.slug,
											item: d
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(dogadjaji, (d) => {
									return createVNode(_sfc_main$62, {
										key: d.slug,
										item: d
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Kartica/Oglas</h2>`);
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(oglasi, (o) => {
										_push(ssrRenderComponent(_sfc_main$84, {
											key: o.slug,
											item: o
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(oglasi, (o) => {
									return createVNode(_sfc_main$84, {
										key: o.slug,
										item: o
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Kartica/Priča — Featured</h2>`);
						_push(ssrRenderComponent(_sfc_main$60, { item: featured }, null, _parent, _scopeId));
						_push(`<h2 class="pt-4 text-xl font-bold text-heading"${_scopeId}>Kartica/Priča</h2>`);
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(price, (p) => {
										_push(ssrRenderComponent(_sfc_main$61, {
											key: p.slug,
											item: p
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(price, (p) => {
									return createVNode(_sfc_main$61, {
										key: p.slug,
										item: p
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><hr class="border-border"${_scopeId}><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Skeleton (učitavanje)</h2>`);
						_push(ssrRenderComponent(_sfc_main$90, null, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(ssrRenderComponent(_sfc_main$76, { count: 4 }, null, _parent, _scopeId));
								else return [createVNode(_sfc_main$76, { count: 4 })];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Prazno stanje</h2>`);
						_push(ssrRenderComponent(_sfc_main$85, {
							title: "Nema rezultata",
							text: "Trenutno nema sadržaja za odabrane filtere. Pokušajte promijeniti pretragu."
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(ssrRenderComponent(_sfc_main$93, {
									variant: "secondary",
									size: "sm"
								}, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(`Očisti filtere`);
										else return [createTextVNode("Očisti filtere")];
									}),
									_: 1
								}, _parent, _scopeId));
								else return [createVNode(_sfc_main$93, {
									variant: "secondary",
									size: "sm"
								}, {
									default: withCtx(() => [createTextVNode("Očisti filtere")]),
									_: 1
								})];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Breadcrumb</h2>`);
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Turizam u Tesliću",
								to: "/turizam"
							},
							{ label: "Planina Borja" }
						] }, null, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Paginacija (stranica ${ssrInterpolate(stranica.value)})</h2>`);
						_push(ssrRenderComponent(_sfc_main$77, {
							modelValue: stranica.value,
							"onUpdate:modelValue": ($event) => stranica.value = $event,
							total: 10
						}, null, _parent, _scopeId));
						_push(`</section><hr class="border-border"${_scopeId}><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Hero — slika-pozadina</h2>`);
						_push(ssrRenderComponent(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: "Dobrodošli u Teslić",
							title: "Domaće, autentično, blizu",
							subtitle: "Otkrijte prirodu, lokalne proizvode i priče kraja oko planine Borje i Banje Vrućice."
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(ssrRenderComponent(_sfc_main$93, {
										variant: "primary",
										icon: "arrow-right",
										"icon-position": "right"
									}, {
										default: withCtx((_, _push, _parent, _scopeId) => {
											if (_push) _push(`Istraži ponudu`);
											else return [createTextVNode("Istraži ponudu")];
										}),
										_: 1
									}, _parent, _scopeId));
									_push(ssrRenderComponent(_sfc_main$93, { variant: "sekundarna" }, {
										default: withCtx((_, _push, _parent, _scopeId) => {
											if (_push) _push(`Pridruži se`);
											else return [createTextVNode("Pridruži se")];
										}),
										_: 1
									}, _parent, _scopeId));
								} else return [createVNode(_sfc_main$93, {
									variant: "primary",
									icon: "arrow-right",
									"icon-position": "right"
								}, {
									default: withCtx(() => [createTextVNode("Istraži ponudu")]),
									_: 1
								}), createVNode(_sfc_main$93, { variant: "sekundarna" }, {
									default: withCtx(() => [createTextVNode("Pridruži se")]),
									_: 1
								})];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`<h2 class="pt-4 text-xl font-bold text-heading"${_scopeId}>Hero — split</h2>`);
						_push(ssrRenderComponent(_sfc_main$96, {
							variant: "split",
							kicker: "Priča sedmice",
							title: "Ljudi koji čuvaju duh Teslića",
							subtitle: "Domaćini, zanatlije i autori koji svojim radom oblikuju turističku ponudu kraja."
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(ssrRenderComponent(_sfc_main$93, { variant: "primary" }, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(`Pročitaj priču`);
										else return [createTextVNode("Pročitaj priču")];
									}),
									_: 1
								}, _parent, _scopeId));
								else return [createVNode(_sfc_main$93, { variant: "primary" }, {
									default: withCtx(() => [createTextVNode("Pročitaj priču")]),
									_: 1
								})];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>SegmentControl + SearchInput</h2><div class="flex flex-wrap items-center gap-4"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$82, {
							modelValue: prikaz.value,
							"onUpdate:modelValue": ($event) => prikaz.value = $event,
							options: prikazOpcije
						}, null, _parent, _scopeId));
						_push(`<span class="text-sm text-text-muted"${_scopeId}>Aktivno: ${ssrInterpolate(prikaz.value)}</span></div><div class="max-w-md"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$79, {
							modelValue: upit.value,
							"onUpdate:modelValue": ($event) => upit.value = $event,
							placeholder: "Pretraži lokalitete…"
						}, null, _parent, _scopeId));
						_push(`</div></section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>FilterBar</h2>`);
						_push(ssrRenderComponent(_sfc_main$80, {
							chips: aktivniFilteri.value,
							onClear: ($event) => aktivniFilteri.value = [],
							onRemove: ukloniFilter
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(ssrRenderComponent(_sfc_main$78, {
										modelValue: filterKat.value,
										"onUpdate:modelValue": ($event) => filterKat.value = $event,
										options: [
											"Zanat",
											"Hrana i piće",
											"Usluge"
										],
										placeholder: "Kategorija"
									}, null, _parent, _scopeId));
									_push(ssrRenderComponent(_sfc_main$79, {
										modelValue: upit.value,
										"onUpdate:modelValue": ($event) => upit.value = $event,
										placeholder: "Pretraga…"
									}, null, _parent, _scopeId));
								} else return [createVNode(_sfc_main$78, {
									modelValue: filterKat.value,
									"onUpdate:modelValue": ($event) => filterKat.value = $event,
									options: [
										"Zanat",
										"Hrana i piće",
										"Usluge"
									],
									placeholder: "Kategorija"
								}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
									modelValue: upit.value,
									"onUpdate:modelValue": ($event) => upit.value = $event,
									placeholder: "Pretraga…"
								}, null, 8, ["modelValue", "onUpdate:modelValue"])];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Galerija + Lightbox</h2>`);
						_push(ssrRenderComponent(_sfc_main$73, { items: galerija }, null, _parent, _scopeId));
						_push(`<h2 class="pt-4 text-xl font-bold text-heading"${_scopeId}>VideoPlayer</h2><div class="max-w-xl"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$58, null, null, _parent, _scopeId));
						_push(`</div></section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>InfoPanel + MiniMap (dvokolonski)</h2><div class="grid gap-6 sm:grid-cols-2 lg:max-w-2xl"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$91, {
							title: "Informacije",
							items: infoItems
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(ssrRenderComponent(_sfc_main$93, {
									variant: "primary",
									icon: "send",
									block: ""
								}, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(`Pošalji upit`);
										else return [createTextVNode("Pošalji upit")];
									}),
									_: 1
								}, _parent, _scopeId));
								else return [createVNode(_sfc_main$93, {
									variant: "primary",
									icon: "send",
									block: ""
								}, {
									default: withCtx(() => [createTextVNode("Pošalji upit")]),
									_: 1
								})];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$72, { label: "Planina Borja" }, null, _parent, _scopeId));
						_push(`</div></section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Stepper</h2>`);
						_push(ssrRenderComponent(_sfc_main$59, { steps: koraci }, null, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>AuthorBlock</h2>`);
						_push(ssrRenderComponent(_sfc_main$57, {
							author: autor,
							to: "/price"
						}, null, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$89, { title: "Povezani sadržaj" }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(biznisi.slice(0, 3), (b) => {
										_push(ssrRenderComponent(_sfc_main$70, {
											key: b.slug,
											item: b
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(biznisi.slice(0, 3), (b) => {
									return openBlock(), createBlock(_sfc_main$70, {
										key: b.slug,
										item: b
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>CTASection</h2>`);
						_push(ssrRenderComponent(_sfc_main$94, {
							title: "Imate biznis ili priču iz Teslića?",
							text: "Pridružite se platformi i predstavite svoju ponudu posjetiocima Teslića."
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(ssrRenderComponent(_sfc_main$93, { variant: "sekundarna" }, {
										default: withCtx((_, _push, _parent, _scopeId) => {
											if (_push) _push(`Registruj biznis`);
											else return [createTextVNode("Registruj biznis")];
										}),
										_: 1
									}, _parent, _scopeId));
									_push(ssrRenderComponent(_sfc_main$93, { variant: "secondary" }, {
										default: withCtx((_, _push, _parent, _scopeId) => {
											if (_push) _push(`Postani autor`);
											else return [createTextVNode("Postani autor")];
										}),
										_: 1
									}, _parent, _scopeId));
								} else return [createVNode(_sfc_main$93, { variant: "sekundarna" }, {
									default: withCtx(() => [createTextVNode("Registruj biznis")]),
									_: 1
								}), createVNode(_sfc_main$93, { variant: "secondary" }, {
									default: withCtx(() => [createTextVNode("Postani autor")]),
									_: 1
								})];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</section><hr class="border-border"${_scopeId}><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>Mapa (Leaflet) — FilterPanel + Mapa + Rezultati</h2><div class="grid gap-4 lg:grid-cols-[300px_1fr]"${_scopeId}><div class="space-y-4"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$55, {
							modelValue: aktivneKat.value,
							"onUpdate:modelValue": ($event) => aktivneKat.value = $event
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$54, {
							items: vidljiviPinovi.value,
							onSelect: ($event) => odabranPin.value = $event
						}, null, _parent, _scopeId));
						_push(`</div>`);
						_push(ssrRenderComponent(MapInteractive_default, {
							items: vidljiviPinovi.value,
							"active-categories": aktivneKat.value,
							height: "560px",
							onSelect: ($event) => odabranPin.value = $event
						}, null, _parent, _scopeId));
						_push(`</div>`);
						if (odabranPin.value) {
							_push(`<div class="max-w-xs"${_scopeId}><p class="mb-2 text-sm text-text-muted"${_scopeId}>Odabran pin → MapPopup:</p>`);
							_push(ssrRenderComponent(_sfc_main$53, {
								item: odabranPin.value,
								onClose: ($event) => odabranPin.value = null
							}, null, _parent, _scopeId));
							_push(`</div>`);
						} else _push(`<!---->`);
						_push(`</section><hr class="border-border"${_scopeId}><section class="space-y-4"${_scopeId}><h2 class="text-xl font-bold text-heading"${_scopeId}>EventCalendar</h2><div class="grid gap-6 lg:grid-cols-[1fr_320px]"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$52, {
							modelValue: odabraniDan.value,
							"onUpdate:modelValue": ($event) => odabraniDan.value = $event,
							events: kalEvents,
							onSelectDay
						}, null, _parent, _scopeId));
						_push(`<div class="space-y-3"${_scopeId}><h3 class="font-heading font-semibold text-heading"${_scopeId}> Događaji (${ssrInterpolate(odabraniDan.value || "odaberi dan")}) </h3>`);
						if (!danEvents.value.length) _push(`<p class="text-sm text-text-muted"${_scopeId}> Klikni na dan s tačkom (12, 21, 28. jun) za listu događaja. </p>`);
						else {
							_push(`<ul class="space-y-2"${_scopeId}><!--[-->`);
							ssrRenderList(danEvents.value, (e) => {
								_push(`<li class="rounded-md border border-border bg-surface p-3"${_scopeId}><p class="font-semibold text-heading"${_scopeId}>${ssrInterpolate(e.naslov)}</p><p class="text-sm text-text-muted"${_scopeId}>${ssrInterpolate(e.vrijeme)} · ${ssrInterpolate(e.lokacija)}</p></li>`);
							});
							_push(`<!--]--></ul>`);
						}
						_push(`</div></div></section>`);
					} else return [
						createVNode("header", null, [createVNode("h1", { class: "text-3xl font-bold text-heading" }, "Komponente — showcase"), createVNode("p", { class: "mt-1 text-text-muted" }, [
							createTextVNode(" Privremena dev ruta "),
							createVNode("code", null, "/_dev"),
							createTextVNode(" za vizuelnu provjeru komponenti (F2 atomi + F4 kartice/stanja). ")
						])]),
						createVNode("section", { class: "space-y-4" }, [
							createVNode("h2", { class: "text-xl font-bold text-heading" }, "Dugmad"),
							createVNode("div", { class: "flex flex-wrap items-center gap-3" }, [(openBlock(), createBlock(Fragment, null, renderList(buttons, (v) => {
								return createVNode(_sfc_main$93, {
									key: v,
									variant: v,
									icon: "arrow-right",
									"icon-position": "right"
								}, {
									default: withCtx(() => [createTextVNode(toDisplayString(v), 1)]),
									_: 2
								}, 1032, ["variant"]);
							}), 64))]),
							createVNode("div", { class: "flex flex-wrap items-center gap-3" }, [(openBlock(), createBlock(Fragment, null, renderList(buttons, (v) => {
								return createVNode(_sfc_main$93, {
									key: v,
									variant: v,
									size: "sm"
								}, {
									default: withCtx(() => [createTextVNode(toDisplayString(v) + " sm", 1)]),
									_: 2
								}, 1032, ["variant"]);
							}), 64)), createVNode(_sfc_main$93, {
								variant: "primary",
								disabled: ""
							}, {
								default: withCtx(() => [createTextVNode("disabled")]),
								_: 1
							})])
						]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Chip / Tag"), createVNode("div", { class: "flex flex-wrap items-center gap-3" }, [
							(openBlock(), createBlock(Fragment, null, renderList(filteri, (f) => {
								return createVNode(_sfc_main$88, {
									key: f,
									variant: "filter",
									label: f,
									active: aktivanFilter.value === f,
									onClick: ($event) => aktivanFilter.value = f
								}, null, 8, [
									"label",
									"active",
									"onClick"
								]);
							}), 64)),
							createVNode(_sfc_main$88, {
								variant: "kategorija",
								label: "Zanat",
								icon: "tag"
							}),
							createVNode(_sfc_main$88, {
								variant: "uklonjiv",
								label: "Borje"
							})
						])]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Badge / Status"), createVNode("div", { class: "flex flex-wrap items-center gap-3" }, [(openBlock(), createBlock(Fragment, null, renderList(badges, (b) => {
							return createVNode(_sfc_main$87, {
								key: b,
								variant: b
							}, null, 8, ["variant"]);
						}), 64))])]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Alert / Poruka stanja"), createVNode("div", { class: "grid max-w-xl gap-3" }, [
							createVNode(_sfc_main$86, {
								variant: "uspjeh",
								title: "Prijava primljena",
								text: "Vaša prijava ide na pregled administratora."
							}),
							createVNode(_sfc_main$86, {
								variant: "greska",
								title: "Greška",
								text: "Molimo provjerite obavezna polja."
							}),
							createVNode(_sfc_main$86, {
								variant: "info",
								text: "Polja označena zvjezdicom su obavezna."
							})
						])]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Forme"), createVNode("div", { class: "grid max-w-xl gap-4" }, [
							createVNode(_sfc_main$68, {
								modelValue: ime.value,
								"onUpdate:modelValue": ($event) => ime.value = $event,
								label: "Ime i prezime",
								placeholder: "npr. Marko Marković",
								required: ""
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$68, {
								label: "E-mail",
								type: "email",
								error: "Unesite ispravnu e-mail adresu."
							}),
							createVNode(_sfc_main$78, {
								modelValue: kat.value,
								"onUpdate:modelValue": ($event) => kat.value = $event,
								label: "Kategorija",
								options: [
									"Zanat",
									"Hrana i piće",
									"Usluge"
								],
								required: ""
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$67, {
								modelValue: poruka.value,
								"onUpdate:modelValue": ($event) => poruka.value = $event,
								label: "Poruka",
								maxlength: 500,
								placeholder: "Vaša poruka…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$66, {
								modelValue: saglasnost.value,
								"onUpdate:modelValue": ($event) => saglasnost.value = $event,
								required: ""
							}, {
								default: withCtx(() => [createTextVNode(" Prihvatam uslove korištenja i obradu podataka ")]),
								_: 1
							}, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$65, {
								modelValue: captcha.value,
								"onUpdate:modelValue": ($event) => captcha.value = $event
							}, null, 8, ["modelValue", "onUpdate:modelValue"])
						])]),
						createVNode("hr", { class: "border-border" }),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Kartica/Biznis"), createVNode(_sfc_main$90, null, {
							default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(biznisi, (b) => {
								return createVNode(_sfc_main$70, {
									key: b.slug,
									item: b
								}, null, 8, ["item"]);
							}), 64))]),
							_: 1
						})]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Kartica/Lokalitet"), createVNode(_sfc_main$90, { cols: 3 }, {
							default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(lokaliteti, (l) => {
								return createVNode(_sfc_main$63, {
									key: l.slug,
									item: l
								}, null, 8, ["item"]);
							}), 64))]),
							_: 1
						})]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Kartica/Događaj"), createVNode(_sfc_main$90, { cols: 3 }, {
							default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(dogadjaji, (d) => {
								return createVNode(_sfc_main$62, {
									key: d.slug,
									item: d
								}, null, 8, ["item"]);
							}), 64))]),
							_: 1
						})]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Kartica/Oglas"), createVNode(_sfc_main$90, { cols: 3 }, {
							default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(oglasi, (o) => {
								return createVNode(_sfc_main$84, {
									key: o.slug,
									item: o
								}, null, 8, ["item"]);
							}), 64))]),
							_: 1
						})]),
						createVNode("section", { class: "space-y-4" }, [
							createVNode("h2", { class: "text-xl font-bold text-heading" }, "Kartica/Priča — Featured"),
							createVNode(_sfc_main$60, { item: featured }),
							createVNode("h2", { class: "pt-4 text-xl font-bold text-heading" }, "Kartica/Priča"),
							createVNode(_sfc_main$90, { cols: 3 }, {
								default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(price, (p) => {
									return createVNode(_sfc_main$61, {
										key: p.slug,
										item: p
									}, null, 8, ["item"]);
								}), 64))]),
								_: 1
							})
						]),
						createVNode("hr", { class: "border-border" }),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Skeleton (učitavanje)"), createVNode(_sfc_main$90, null, {
							default: withCtx(() => [createVNode(_sfc_main$76, { count: 4 })]),
							_: 1
						})]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Prazno stanje"), createVNode(_sfc_main$85, {
							title: "Nema rezultata",
							text: "Trenutno nema sadržaja za odabrane filtere. Pokušajte promijeniti pretragu."
						}, {
							default: withCtx(() => [createVNode(_sfc_main$93, {
								variant: "secondary",
								size: "sm"
							}, {
								default: withCtx(() => [createTextVNode("Očisti filtere")]),
								_: 1
							})]),
							_: 1
						})]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Breadcrumb"), createVNode(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Turizam u Tesliću",
								to: "/turizam"
							},
							{ label: "Planina Borja" }
						] })]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Paginacija (stranica " + toDisplayString(stranica.value) + ")", 1), createVNode(_sfc_main$77, {
							modelValue: stranica.value,
							"onUpdate:modelValue": ($event) => stranica.value = $event,
							total: 10
						}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
						createVNode("hr", { class: "border-border" }),
						createVNode("section", { class: "space-y-4" }, [
							createVNode("h2", { class: "text-xl font-bold text-heading" }, "Hero — slika-pozadina"),
							createVNode(_sfc_main$96, {
								variant: "slika-pozadina",
								kicker: "Dobrodošli u Teslić",
								title: "Domaće, autentično, blizu",
								subtitle: "Otkrijte prirodu, lokalne proizvode i priče kraja oko planine Borje i Banje Vrućice."
							}, {
								default: withCtx(() => [createVNode(_sfc_main$93, {
									variant: "primary",
									icon: "arrow-right",
									"icon-position": "right"
								}, {
									default: withCtx(() => [createTextVNode("Istraži ponudu")]),
									_: 1
								}), createVNode(_sfc_main$93, { variant: "sekundarna" }, {
									default: withCtx(() => [createTextVNode("Pridruži se")]),
									_: 1
								})]),
								_: 1
							}),
							createVNode("h2", { class: "pt-4 text-xl font-bold text-heading" }, "Hero — split"),
							createVNode(_sfc_main$96, {
								variant: "split",
								kicker: "Priča sedmice",
								title: "Ljudi koji čuvaju duh Teslića",
								subtitle: "Domaćini, zanatlije i autori koji svojim radom oblikuju turističku ponudu kraja."
							}, {
								default: withCtx(() => [createVNode(_sfc_main$93, { variant: "primary" }, {
									default: withCtx(() => [createTextVNode("Pročitaj priču")]),
									_: 1
								})]),
								_: 1
							})
						]),
						createVNode("section", { class: "space-y-4" }, [
							createVNode("h2", { class: "text-xl font-bold text-heading" }, "SegmentControl + SearchInput"),
							createVNode("div", { class: "flex flex-wrap items-center gap-4" }, [createVNode(_sfc_main$82, {
								modelValue: prikaz.value,
								"onUpdate:modelValue": ($event) => prikaz.value = $event,
								options: prikazOpcije
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode("span", { class: "text-sm text-text-muted" }, "Aktivno: " + toDisplayString(prikaz.value), 1)]),
							createVNode("div", { class: "max-w-md" }, [createVNode(_sfc_main$79, {
								modelValue: upit.value,
								"onUpdate:modelValue": ($event) => upit.value = $event,
								placeholder: "Pretraži lokalitete…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])])
						]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "FilterBar"), createVNode(_sfc_main$80, {
							chips: aktivniFilteri.value,
							onClear: ($event) => aktivniFilteri.value = [],
							onRemove: ukloniFilter
						}, {
							default: withCtx(() => [createVNode(_sfc_main$78, {
								modelValue: filterKat.value,
								"onUpdate:modelValue": ($event) => filterKat.value = $event,
								options: [
									"Zanat",
									"Hrana i piće",
									"Usluge"
								],
								placeholder: "Kategorija"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
								modelValue: upit.value,
								"onUpdate:modelValue": ($event) => upit.value = $event,
								placeholder: "Pretraga…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
							_: 1
						}, 8, ["chips", "onClear"])]),
						createVNode("section", { class: "space-y-4" }, [
							createVNode("h2", { class: "text-xl font-bold text-heading" }, "Galerija + Lightbox"),
							createVNode(_sfc_main$73, { items: galerija }),
							createVNode("h2", { class: "pt-4 text-xl font-bold text-heading" }, "VideoPlayer"),
							createVNode("div", { class: "max-w-xl" }, [createVNode(_sfc_main$58)])
						]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "InfoPanel + MiniMap (dvokolonski)"), createVNode("div", { class: "grid gap-6 sm:grid-cols-2 lg:max-w-2xl" }, [createVNode(_sfc_main$91, {
							title: "Informacije",
							items: infoItems
						}, {
							default: withCtx(() => [createVNode(_sfc_main$93, {
								variant: "primary",
								icon: "send",
								block: ""
							}, {
								default: withCtx(() => [createTextVNode("Pošalji upit")]),
								_: 1
							})]),
							_: 1
						}), createVNode(_sfc_main$72, { label: "Planina Borja" })])]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "Stepper"), createVNode(_sfc_main$59, { steps: koraci })]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "AuthorBlock"), createVNode(_sfc_main$57, {
							author: autor,
							to: "/price"
						})]),
						createVNode("section", { class: "space-y-4" }, [createVNode(_sfc_main$89, { title: "Povezani sadržaj" }, {
							default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(biznisi.slice(0, 3), (b) => {
								return openBlock(), createBlock(_sfc_main$70, {
									key: b.slug,
									item: b
								}, null, 8, ["item"]);
							}), 128))]),
							_: 1
						})]),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "CTASection"), createVNode(_sfc_main$94, {
							title: "Imate biznis ili priču iz Teslića?",
							text: "Pridružite se platformi i predstavite svoju ponudu posjetiocima Teslića."
						}, {
							default: withCtx(() => [createVNode(_sfc_main$93, { variant: "sekundarna" }, {
								default: withCtx(() => [createTextVNode("Registruj biznis")]),
								_: 1
							}), createVNode(_sfc_main$93, { variant: "secondary" }, {
								default: withCtx(() => [createTextVNode("Postani autor")]),
								_: 1
							})]),
							_: 1
						})]),
						createVNode("hr", { class: "border-border" }),
						createVNode("section", { class: "space-y-4" }, [
							createVNode("h2", { class: "text-xl font-bold text-heading" }, "Mapa (Leaflet) — FilterPanel + Mapa + Rezultati"),
							createVNode("div", { class: "grid gap-4 lg:grid-cols-[300px_1fr]" }, [createVNode("div", { class: "space-y-4" }, [createVNode(_sfc_main$55, {
								modelValue: aktivneKat.value,
								"onUpdate:modelValue": ($event) => aktivneKat.value = $event
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$54, {
								items: vidljiviPinovi.value,
								onSelect: ($event) => odabranPin.value = $event
							}, null, 8, ["items", "onSelect"])]), createVNode(MapInteractive_default, {
								items: vidljiviPinovi.value,
								"active-categories": aktivneKat.value,
								height: "560px",
								onSelect: ($event) => odabranPin.value = $event
							}, null, 8, [
								"items",
								"active-categories",
								"onSelect"
							])]),
							odabranPin.value ? (openBlock(), createBlock("div", {
								key: 0,
								class: "max-w-xs"
							}, [createVNode("p", { class: "mb-2 text-sm text-text-muted" }, "Odabran pin → MapPopup:"), createVNode(_sfc_main$53, {
								item: odabranPin.value,
								onClose: ($event) => odabranPin.value = null
							}, null, 8, ["item", "onClose"])])) : createCommentVNode("", true)
						]),
						createVNode("hr", { class: "border-border" }),
						createVNode("section", { class: "space-y-4" }, [createVNode("h2", { class: "text-xl font-bold text-heading" }, "EventCalendar"), createVNode("div", { class: "grid gap-6 lg:grid-cols-[1fr_320px]" }, [createVNode(_sfc_main$52, {
							modelValue: odabraniDan.value,
							"onUpdate:modelValue": ($event) => odabraniDan.value = $event,
							events: kalEvents,
							onSelectDay
						}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode("div", { class: "space-y-3" }, [createVNode("h3", { class: "font-heading font-semibold text-heading" }, " Događaji (" + toDisplayString(odabraniDan.value || "odaberi dan") + ") ", 1), !danEvents.value.length ? (openBlock(), createBlock("p", {
							key: 0,
							class: "text-sm text-text-muted"
						}, " Klikni na dan s tačkom (12, 21, 28. jun) za listu događaja. ")) : (openBlock(), createBlock("ul", {
							key: 1,
							class: "space-y-2"
						}, [(openBlock(true), createBlock(Fragment, null, renderList(danEvents.value, (e) => {
							return openBlock(), createBlock("li", {
								key: e.slug,
								class: "rounded-md border border-border bg-surface p-3"
							}, [createVNode("p", { class: "font-semibold text-heading" }, toDisplayString(e.naslov), 1), createVNode("p", { class: "text-sm text-text-muted" }, toDisplayString(e.vrijeme) + " · " + toDisplayString(e.lokacija), 1)]);
						}), 128))]))])])])
					];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$51 = _sfc_main$51.setup;
_sfc_main$51.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Dev.vue");
	return _sfc_setup$51 ? _sfc_setup$51(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/EventDetail.vue
var EventDetail_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$50 });
var _sfc_main$50 = {
	__name: "EventDetail",
	__ssrInlineRender: true,
	props: {
		slug: {
			type: String,
			default: ""
		},
		dogadjaj: {
			type: Object,
			default: null
		},
		slicni: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const dogadjaj = computed(() => props.dogadjaj);
		const slicni = computed(() => props.slicni);
		const infoItems = computed(() => {
			if (!dogadjaj.value) return [];
			const d = dogadjaj.value;
			const items = [];
			if (d.datum) items.push({
				icon: "calendar",
				label: "Datum",
				value: d.datum
			});
			if (d.vrijeme) items.push({
				icon: "clock",
				label: "Vrijeme",
				value: d.vrijeme
			});
			if (d.lokacija) items.push({
				icon: "map-pin",
				label: "Lokacija",
				value: d.lokacija
			});
			if (d.organizator) items.push({
				icon: "user",
				label: "Organizator",
				value: d.organizator
			});
			return items;
		});
		const dodatUKalendar = ref(false);
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "py-8"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!dogadjaj.value) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Događaj nije pronađen",
						text: "Traženi događaj ne postoji ili je uklonjen."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/dogadjaji"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Nazad na događaje `);
									else return [createTextVNode(" Nazad na događaje ")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/dogadjaji"
							}, {
								default: withCtx(() => [createTextVNode(" Nazad na događaje ")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Događaji",
								to: "/dogadjaji"
							},
							{ label: dogadjaj.value.naslov }
						] }, null, _parent, _scopeId));
						_push(`<div class="mt-6 overflow-hidden rounded-lg"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: dogadjaj.value.datum,
							title: dogadjaj.value.naslov,
							subtitle: dogadjaj.value.vrijeme ? `${dogadjaj.value.vrijeme} · ${dogadjaj.value.lokacija}` : dogadjaj.value.lokacija,
							image: dogadjaj.value.slika
						}, null, _parent, _scopeId));
						_push(`</div>`);
						if (dogadjaj.value.zavrseno) {
							_push(`<div class="mt-6"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$87, { variant: "zavrseno" }, null, _parent, _scopeId));
							_push(`</div>`);
						} else _push(`<!---->`);
						_push(`<div class="mt-10 grid gap-8 lg:grid-cols-3"${_scopeId}><div class="space-y-8 lg:col-span-2"${_scopeId}>`);
						if (dogadjaj.value.opisDug) _push(`<section${_scopeId}><h2 class="mb-3 font-heading text-2xl font-bold text-heading"${_scopeId}>O događaju</h2><p class="whitespace-pre-line leading-relaxed text-text"${_scopeId}>${ssrInterpolate(dogadjaj.value.opisDug)}</p></section>`);
						else _push(`<!---->`);
						if (dogadjaj.value.galerija?.length) {
							_push(`<section${_scopeId}><h2 class="mb-4 font-heading text-2xl font-bold text-heading"${_scopeId}>Galerija</h2>`);
							_push(ssrRenderComponent(_sfc_main$73, { items: dogadjaj.value.galerija }, null, _parent, _scopeId));
							_push(`</section>`);
						} else _push(`<!---->`);
						_push(`</div><div class="space-y-6"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$91, {
							title: "Informacije",
							items: infoItems.value
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(ssrRenderComponent(_sfc_main$93, {
										variant: "primary",
										icon: "calendar-plus",
										block: "",
										disabled: dogadjaj.value.zavrseno,
										onClick: ($event) => dodatUKalendar.value = true
									}, {
										default: withCtx((_, _push, _parent, _scopeId) => {
											if (_push) _push(` Dodaj u kalendar `);
											else return [createTextVNode(" Dodaj u kalendar ")];
										}),
										_: 1
									}, _parent, _scopeId));
									if (dodatUKalendar.value) _push(ssrRenderComponent(_sfc_main$86, {
										variant: "uspjeh",
										class: "mt-4",
										text: "Termin događaja je zabilježen."
									}, null, _parent, _scopeId));
									else _push(`<!---->`);
								} else return [createVNode(_sfc_main$93, {
									variant: "primary",
									icon: "calendar-plus",
									block: "",
									disabled: dogadjaj.value.zavrseno,
									onClick: ($event) => dodatUKalendar.value = true
								}, {
									default: withCtx(() => [createTextVNode(" Dodaj u kalendar ")]),
									_: 1
								}, 8, ["disabled", "onClick"]), dodatUKalendar.value ? (openBlock(), createBlock(_sfc_main$86, {
									key: 0,
									variant: "uspjeh",
									class: "mt-4",
									text: "Termin događaja je zabilježen."
								})) : createCommentVNode("", true)];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$72, { label: dogadjaj.value.lokacija }, null, _parent, _scopeId));
						_push(`</div></div>`);
						if (slicni.value.length) _push(ssrRenderComponent(_sfc_main$89, { title: "Drugi događaji" }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(slicni.value, (d) => {
										_push(ssrRenderComponent(_sfc_main$62, {
											key: d.slug,
											item: d
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (d) => {
									return openBlock(), createBlock(_sfc_main$62, {
										key: d.slug,
										item: d
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!dogadjaj.value ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Događaj nije pronađen",
						text: "Traženi događaj ne postoji ili je uklonjen."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "arrow-left",
							to: "/dogadjaji"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na događaje ")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [
						createVNode(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Događaji",
								to: "/dogadjaji"
							},
							{ label: dogadjaj.value.naslov }
						] }, null, 8, ["items"]),
						createVNode("div", { class: "mt-6 overflow-hidden rounded-lg" }, [createVNode(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: dogadjaj.value.datum,
							title: dogadjaj.value.naslov,
							subtitle: dogadjaj.value.vrijeme ? `${dogadjaj.value.vrijeme} · ${dogadjaj.value.lokacija}` : dogadjaj.value.lokacija,
							image: dogadjaj.value.slika
						}, null, 8, [
							"kicker",
							"title",
							"subtitle",
							"image"
						])]),
						dogadjaj.value.zavrseno ? (openBlock(), createBlock("div", {
							key: 0,
							class: "mt-6"
						}, [createVNode(_sfc_main$87, { variant: "zavrseno" })])) : createCommentVNode("", true),
						createVNode("div", { class: "mt-10 grid gap-8 lg:grid-cols-3" }, [createVNode("div", { class: "space-y-8 lg:col-span-2" }, [dogadjaj.value.opisDug ? (openBlock(), createBlock("section", { key: 0 }, [createVNode("h2", { class: "mb-3 font-heading text-2xl font-bold text-heading" }, "O događaju"), createVNode("p", { class: "whitespace-pre-line leading-relaxed text-text" }, toDisplayString(dogadjaj.value.opisDug), 1)])) : createCommentVNode("", true), dogadjaj.value.galerija?.length ? (openBlock(), createBlock("section", { key: 1 }, [createVNode("h2", { class: "mb-4 font-heading text-2xl font-bold text-heading" }, "Galerija"), createVNode(_sfc_main$73, { items: dogadjaj.value.galerija }, null, 8, ["items"])])) : createCommentVNode("", true)]), createVNode("div", { class: "space-y-6" }, [createVNode(_sfc_main$91, {
							title: "Informacije",
							items: infoItems.value
						}, {
							default: withCtx(() => [createVNode(_sfc_main$93, {
								variant: "primary",
								icon: "calendar-plus",
								block: "",
								disabled: dogadjaj.value.zavrseno,
								onClick: ($event) => dodatUKalendar.value = true
							}, {
								default: withCtx(() => [createTextVNode(" Dodaj u kalendar ")]),
								_: 1
							}, 8, ["disabled", "onClick"]), dodatUKalendar.value ? (openBlock(), createBlock(_sfc_main$86, {
								key: 0,
								variant: "uspjeh",
								class: "mt-4",
								text: "Termin događaja je zabilježen."
							})) : createCommentVNode("", true)]),
							_: 1
						}, 8, ["items"]), createVNode(_sfc_main$72, { label: dogadjaj.value.lokacija }, null, 8, ["label"])])]),
						slicni.value.length ? (openBlock(), createBlock(_sfc_main$89, {
							key: 1,
							title: "Drugi događaji"
						}, {
							default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (d) => {
								return openBlock(), createBlock(_sfc_main$62, {
									key: d.slug,
									item: d
								}, null, 8, ["item"]);
							}), 128))]),
							_: 1
						})) : createCommentVNode("", true)
					], 64))];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$50 = _sfc_main$50.setup;
_sfc_main$50.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/EventDetail.vue");
	return _sfc_setup$50 ? _sfc_setup$50(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Events.vue
var Events_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$49 });
var PO_STRANICI$3 = 8;
var _sfc_main$49 = {
	__name: "Events",
	__ssrInlineRender: true,
	props: { dogadjaji: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		const props = __props;
		const data = computed(() => props.dogadjaji);
		const prikaz = ref("lista");
		const upit = ref("");
		const period = ref("");
		const stranica = ref(1);
		const odabraniDan = ref("");
		const danDogadjaji = ref([]);
		const prikazOpcije = [{
			value: "lista",
			label: "Lista",
			icon: "list"
		}, {
			value: "kalendar",
			label: "Kalendar",
			icon: "calendar"
		}];
		const periodOpcije = [{
			value: "nadolazeci",
			label: "Nadolazeći"
		}, {
			value: "protekli",
			label: "Protekli"
		}];
		const filtrirano = computed(() => {
			let lista = data.value || [];
			if (period.value === "nadolazeci") lista = lista.filter((d) => !d.zavrseno);
			if (period.value === "protekli") lista = lista.filter((d) => d.zavrseno);
			if (upit.value.trim()) {
				const q = upit.value.trim().toLowerCase();
				lista = lista.filter((d) => d.naslov?.toLowerCase().includes(q) || d.lokacija?.toLowerCase().includes(q));
			}
			return lista;
		});
		const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI$3)));
		const vidljivi = computed(() => filtrirano.value.slice((stranica.value - 1) * PO_STRANICI$3, stranica.value * PO_STRANICI$3));
		const kalendarEvents = computed(() => (data.value || []).map((d) => ({
			...d,
			date: d.datum
		})));
		const aktivniChipovi = computed(() => {
			const chips = [];
			if (period.value) {
				const p = periodOpcije.find((o) => o.value === period.value);
				chips.push({
					key: "period",
					label: p ? p.label : period.value
				});
			}
			if (upit.value.trim()) chips.push({
				key: "upit",
				label: `„${upit.value.trim()}”`
			});
			return chips;
		});
		watch([period, upit], () => {
			stranica.value = 1;
		});
		function ocisti() {
			period.value = "";
			upit.value = "";
		}
		function ukloni(key) {
			if (key === "period") period.value = "";
			if (key === "upit") upit.value = "";
		}
		function onSelectDay({ events }) {
			danDogadjaji.value = events;
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Događaji" }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Događaji" }] })];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="flex flex-wrap items-start justify-between gap-4"${_scopeId}><div${_scopeId}><h1 class="font-heading text-3xl font-bold text-heading md:text-4xl"${_scopeId}> Događaji i dešavanja </h1><p class="mt-2 max-w-2xl text-text-muted"${_scopeId}> Festivali, sajmovi, koncerti i manifestacije u Tesliću i okolini. </p></div>`);
						_push(ssrRenderComponent(_sfc_main$82, {
							modelValue: prikaz.value,
							"onUpdate:modelValue": ($event) => prikaz.value = $event,
							options: prikazOpcije
						}, null, _parent, _scopeId));
						_push(`</div>`);
					} else return [createVNode("div", { class: "flex flex-wrap items-start justify-between gap-4" }, [createVNode("div", null, [createVNode("h1", { class: "font-heading text-3xl font-bold text-heading md:text-4xl" }, " Događaji i dešavanja "), createVNode("p", { class: "mt-2 max-w-2xl text-text-muted" }, " Festivali, sajmovi, koncerti i manifestacije u Tesliću i okolini. ")]), createVNode(_sfc_main$82, {
						modelValue: prikaz.value,
						"onUpdate:modelValue": ($event) => prikaz.value = $event,
						options: prikazOpcije
					}, null, 8, ["modelValue", "onUpdate:modelValue"])])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) {
								_push(ssrRenderComponent(_sfc_main$78, {
									modelValue: period.value,
									"onUpdate:modelValue": ($event) => period.value = $event,
									options: periodOpcije,
									placeholder: "Svi periodi"
								}, null, _parent, _scopeId));
								_push(ssrRenderComponent(_sfc_main$79, {
									modelValue: upit.value,
									"onUpdate:modelValue": ($event) => upit.value = $event,
									placeholder: "Pretraži događaje…"
								}, null, _parent, _scopeId));
							} else return [createVNode(_sfc_main$78, {
								modelValue: period.value,
								"onUpdate:modelValue": ($event) => period.value = $event,
								options: periodOpcije,
								placeholder: "Svi periodi"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
								modelValue: upit.value,
								"onUpdate:modelValue": ($event) => upit.value = $event,
								placeholder: "Pretraži događaje…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx(() => [createVNode(_sfc_main$78, {
							modelValue: period.value,
							"onUpdate:modelValue": ($event) => period.value = $event,
							options: periodOpcije,
							placeholder: "Svi periodi"
						}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
							modelValue: upit.value,
							"onUpdate:modelValue": ($event) => upit.value = $event,
							placeholder: "Pretraži događaje…"
						}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
						_: 1
					}, 8, ["chips"])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (prikaz.value === "lista") {
						_push(`<!--[-->`);
						if (!vidljivi.value.length) _push(ssrRenderComponent(_sfc_main$85, {
							title: "Nema događaja",
							text: "Za odabrane filtere trenutno nema događaja. Pokušajte promijeniti period ili pretragu."
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(ssrRenderComponent(_sfc_main$93, {
									variant: "secondary",
									size: "sm",
									onClick: ocisti
								}, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(`Očisti filtere`);
										else return [createTextVNode("Očisti filtere")];
									}),
									_: 1
								}, _parent, _scopeId));
								else return [createVNode(_sfc_main$93, {
									variant: "secondary",
									size: "sm",
									onClick: ocisti
								}, {
									default: withCtx(() => [createTextVNode("Očisti filtere")]),
									_: 1
								})];
							}),
							_: 1
						}, _parent, _scopeId));
						else {
							_push(`<!--[-->`);
							_push(ssrRenderComponent(_sfc_main$90, null, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) {
										_push(`<!--[-->`);
										ssrRenderList(vidljivi.value, (d) => {
											_push(ssrRenderComponent(_sfc_main$62, {
												key: d.slug,
												item: d
											}, null, _parent, _scopeId));
										});
										_push(`<!--]-->`);
									} else return [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (d) => {
										return openBlock(), createBlock(_sfc_main$62, {
											key: d.slug,
											item: d
										}, null, 8, ["item"]);
									}), 128))];
								}),
								_: 1
							}, _parent, _scopeId));
							if (ukupnoStranica.value > 1) {
								_push(`<div class="mt-10 flex justify-center"${_scopeId}>`);
								_push(ssrRenderComponent(_sfc_main$77, {
									modelValue: stranica.value,
									"onUpdate:modelValue": ($event) => stranica.value = $event,
									total: ukupnoStranica.value
								}, null, _parent, _scopeId));
								_push(`</div>`);
							} else _push(`<!---->`);
							_push(`<!--]-->`);
						}
						_push(`<!--]-->`);
					} else {
						_push(`<!--[-->`);
						_push(`<div class="grid gap-6 lg:grid-cols-[1fr_340px]"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$52, {
							modelValue: odabraniDan.value,
							"onUpdate:modelValue": ($event) => odabraniDan.value = $event,
							events: kalendarEvents.value,
							onSelectDay
						}, null, _parent, _scopeId));
						_push(`<div class="space-y-3"${_scopeId}><h2 class="font-heading text-lg font-semibold text-heading"${_scopeId}> Događaji ${ssrInterpolate(odabraniDan.value ? `(${odabraniDan.value})` : "")}</h2>`);
						if (!odabraniDan.value) _push(`<p class="text-sm text-text-muted"${_scopeId}> Odaberite dan u kalendaru da vidite događaje. </p>`);
						else if (!danDogadjaji.value.length) _push(ssrRenderComponent(_sfc_main$85, {
							icon: "calendar",
							title: "Nema događaja",
							text: "Na odabrani dan nema zakazanih događaja."
						}, null, _parent, _scopeId));
						else {
							_push(`<div class="space-y-4"${_scopeId}><!--[-->`);
							ssrRenderList(danDogadjaji.value, (d) => {
								_push(ssrRenderComponent(_sfc_main$62, {
									key: d.slug,
									item: d
								}, null, _parent, _scopeId));
							});
							_push(`<!--]--></div>`);
						}
						_push(`</div></div>`);
						_push(`<!--]-->`);
					}
					else return [prikaz.value === "lista" ? (openBlock(), createBlock(Fragment, { key: 1 }, [!vidljivi.value.length ? (openBlock(), createBlock(_sfc_main$85, {
						key: 1,
						title: "Nema događaja",
						text: "Za odabrane filtere trenutno nema događaja. Pokušajte promijeniti period ili pretragu."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							size: "sm",
							onClick: ocisti
						}, {
							default: withCtx(() => [createTextVNode("Očisti filtere")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 2 }, [createVNode(_sfc_main$90, null, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (d) => {
							return openBlock(), createBlock(_sfc_main$62, {
								key: d.slug,
								item: d
							}, null, 8, ["item"]);
						}), 128))]),
						_: 1
					}), ukupnoStranica.value > 1 ? (openBlock(), createBlock("div", {
						key: 0,
						class: "mt-10 flex justify-center"
					}, [createVNode(_sfc_main$77, {
						modelValue: stranica.value,
						"onUpdate:modelValue": ($event) => stranica.value = $event,
						total: ukupnoStranica.value
					}, null, 8, [
						"modelValue",
						"onUpdate:modelValue",
						"total"
					])])) : createCommentVNode("", true)], 64))], 64)) : (openBlock(), createBlock(Fragment, { key: 2 }, [(openBlock(), createBlock("div", {
						key: 1,
						class: "grid gap-6 lg:grid-cols-[1fr_340px]"
					}, [createVNode(_sfc_main$52, {
						modelValue: odabraniDan.value,
						"onUpdate:modelValue": ($event) => odabraniDan.value = $event,
						events: kalendarEvents.value,
						onSelectDay
					}, null, 8, [
						"modelValue",
						"onUpdate:modelValue",
						"events"
					]), createVNode("div", { class: "space-y-3" }, [createVNode("h2", { class: "font-heading text-lg font-semibold text-heading" }, " Događaji " + toDisplayString(odabraniDan.value ? `(${odabraniDan.value})` : ""), 1), !odabraniDan.value ? (openBlock(), createBlock("p", {
						key: 0,
						class: "text-sm text-text-muted"
					}, " Odaberite dan u kalendaru da vidite događaje. ")) : !danDogadjaji.value.length ? (openBlock(), createBlock(_sfc_main$85, {
						key: 1,
						icon: "calendar",
						title: "Nema događaja",
						text: "Na odabrani dan nema zakazanih događaja."
					})) : (openBlock(), createBlock("div", {
						key: 2,
						class: "space-y-4"
					}, [(openBlock(true), createBlock(Fragment, null, renderList(danDogadjaji.value, (d) => {
						return openBlock(), createBlock(_sfc_main$62, {
							key: d.slug,
							item: d
						}, null, 8, ["item"]);
					}), 128))]))])]))], 64))];
				}),
				_: 1
			}, _parent));
			_push(`</main>`);
		};
	}
};
var _sfc_setup$49 = _sfc_main$49.setup;
_sfc_main$49.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Events.vue");
	return _sfc_setup$49 ? _sfc_setup$49(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/ForgotPassword.vue
var ForgotPassword_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$48 });
var _sfc_main$48 = {
	__name: "ForgotPassword",
	__ssrInlineRender: true,
	setup(__props) {
		const email = ref("");
		const poslano = ref(false);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<section${ssrRenderAttrs(mergeProps({ class: "bg-surface-alt" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "flex min-h-[600px] items-center justify-center py-16" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8"${_scopeId}>`);
						if (!poslano.value) {
							_push(`<!--[--><h1 class="font-heading text-2xl font-bold text-heading"${_scopeId}>Zaboravljena lozinka</h1><p class="text-sm leading-relaxed text-text-muted"${_scopeId}> Unesite e-mail adresu vašeg naloga i poslaćemo vam link za postavljanje nove lozinke. </p>`);
							_push(ssrRenderComponent(_sfc_main$68, {
								modelValue: email.value,
								"onUpdate:modelValue": ($event) => email.value = $event,
								label: "E-mail",
								type: "email",
								placeholder: "marko@primjer.ba"
							}, null, _parent, _scopeId));
							_push(ssrRenderComponent(_sfc_main$93, {
								variant: "primary",
								block: "",
								onClick: ($event) => poslano.value = true
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Pošalji link za reset `);
									else return [createTextVNode(" Pošalji link za reset ")];
								}),
								_: 1
							}, _parent, _scopeId));
							_push(ssrRenderComponent(_sfc_main$93, {
								to: "/prijava",
								variant: "ghost",
								block: "",
								icon: "arrow-left"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Nazad na prijavu `);
									else return [createTextVNode(" Nazad na prijavu ")];
								}),
								_: 1
							}, _parent, _scopeId));
							_push(`<!--]-->`);
						} else {
							_push(`<!--[--><h1 class="font-heading text-2xl font-bold text-heading"${_scopeId}>Provjerite e-mail</h1>`);
							_push(ssrRenderComponent(_sfc_main$86, {
								variant: "uspjeh",
								title: "Link je poslan",
								text: "Link za resetovanje lozinke je poslan na vašu e-mail adresu."
							}, null, _parent, _scopeId));
							_push(`<p class="text-[13px] leading-relaxed text-text-muted"${_scopeId}> Niste primili e-mail? Provjerite spam folder ili pokušajte ponovo za nekoliko minuta. </p>`);
							_push(ssrRenderComponent(_sfc_main$93, {
								to: "/prijava",
								variant: "ghost",
								block: "",
								icon: "arrow-left"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Nazad na prijavu `);
									else return [createTextVNode(" Nazad na prijavu ")];
								}),
								_: 1
							}, _parent, _scopeId));
							_push(`<!--]-->`);
						}
						_push(`</div>`);
					} else return [createVNode("div", { class: "w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8" }, [!poslano.value ? (openBlock(), createBlock(Fragment, { key: 0 }, [
						createVNode("h1", { class: "font-heading text-2xl font-bold text-heading" }, "Zaboravljena lozinka"),
						createVNode("p", { class: "text-sm leading-relaxed text-text-muted" }, " Unesite e-mail adresu vašeg naloga i poslaćemo vam link za postavljanje nove lozinke. "),
						createVNode(_sfc_main$68, {
							modelValue: email.value,
							"onUpdate:modelValue": ($event) => email.value = $event,
							label: "E-mail",
							type: "email",
							placeholder: "marko@primjer.ba"
						}, null, 8, ["modelValue", "onUpdate:modelValue"]),
						createVNode(_sfc_main$93, {
							variant: "primary",
							block: "",
							onClick: ($event) => poslano.value = true
						}, {
							default: withCtx(() => [createTextVNode(" Pošalji link za reset ")]),
							_: 1
						}, 8, ["onClick"]),
						createVNode(_sfc_main$93, {
							to: "/prijava",
							variant: "ghost",
							block: "",
							icon: "arrow-left"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na prijavu ")]),
							_: 1
						})
					], 64)) : (openBlock(), createBlock(Fragment, { key: 1 }, [
						createVNode("h1", { class: "font-heading text-2xl font-bold text-heading" }, "Provjerite e-mail"),
						createVNode(_sfc_main$86, {
							variant: "uspjeh",
							title: "Link je poslan",
							text: "Link za resetovanje lozinke je poslan na vašu e-mail adresu."
						}),
						createVNode("p", { class: "text-[13px] leading-relaxed text-text-muted" }, " Niste primili e-mail? Provjerite spam folder ili pokušajte ponovo za nekoliko minuta. "),
						createVNode(_sfc_main$93, {
							to: "/prijava",
							variant: "ghost",
							block: "",
							icon: "arrow-left"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na prijavu ")]),
							_: 1
						})
					], 64))])];
				}),
				_: 1
			}, _parent));
			_push(`</section>`);
		};
	}
};
var _sfc_setup$48 = _sfc_main$48.setup;
_sfc_main$48.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/ForgotPassword.vue");
	return _sfc_setup$48 ? _sfc_setup$48(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/SectionHeader.vue
var _sfc_main$47 = {
	__name: "SectionHeader",
	__ssrInlineRender: true,
	props: {
		title: {
			type: String,
			required: true
		},
		linkText: {
			type: String,
			default: ""
		},
		to: {
			type: [String, Object],
			default: null
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex items-center justify-between gap-4" }, _attrs))}><h2 class="font-heading text-[22px] font-bold text-heading md:text-[28px]">${ssrInterpolate(__props.title)}</h2>`);
			if (__props.linkText && __props.to) _push(ssrRenderComponent(unref(Link), {
				href: __props.to,
				class: "flex shrink-0 items-center gap-1 text-[15px] font-semibold text-primary hover:underline"
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`${ssrInterpolate(__props.linkText)} `);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "chevron-right",
							size: 16
						}, null, _parent, _scopeId));
					} else return [createTextVNode(toDisplayString(__props.linkText) + " ", 1), createVNode(_sfc_main$97, {
						name: "chevron-right",
						size: 16
					})];
				}),
				_: 1
			}, _parent));
			else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$47 = _sfc_main$47.setup;
_sfc_main$47.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/SectionHeader.vue");
	return _sfc_setup$47 ? _sfc_setup$47(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Home.vue
var Home_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$46 });
var _sfc_main$46 = {
	__name: "Home",
	__ssrInlineRender: true,
	setup(__props) {
		const img = (id) => `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=1080&q=80`;
		const heroImg = img("1574410187921-bca6826880c0");
		const kategorije = [
			{
				label: "Domaće je najbolje",
				icon: "hrana",
				href: "/domace-je-najbolje"
			},
			{
				label: "Turizam",
				icon: "priroda",
				href: "/turizam"
			},
			{
				label: "Događaji",
				icon: "calendar",
				href: "/dogadjaji"
			},
			{
				label: "Mapa ponude",
				icon: "map-pin",
				href: "/mapa"
			},
			{
				label: "Priče",
				icon: "book-open",
				href: "/price"
			},
			{
				label: "Oglasi",
				icon: "briefcase",
				href: "/oglasi"
			}
		];
		const proizvodi = [
			{
				slug: "pcelarstvo-borja",
				naslov: "Pčelarstvo Borja",
				opis: "Domaći bagremov i livadski med sa obronaka Borja.",
				kategorija: {
					label: "Hrana i piće",
					icon: "hrana"
				},
				lokacija: "Borja",
				slika: img("1619522893151-bb5138b60292")
			},
			{
				slug: "rakija-ocaus",
				naslov: "Rakija Očauš",
				opis: "Prepečenica i šljiva po starom receptu iz sela pod Očaušem.",
				kategorija: {
					label: "Hrana i piće",
					icon: "hrana"
				},
				lokacija: "Očauš",
				slika: img("1766388974047-a993ab02d5a9")
			},
			{
				slug: "sirana-vrucica",
				naslov: "Sirana Vrućica",
				opis: "Mladi i zreli domaći sir od svježeg kravljeg mlijeka.",
				kategorija: {
					label: "Hrana i piće",
					icon: "hrana"
				},
				lokacija: "Banja Vrućica",
				slika: img("1615932744704-683bbbab07fe")
			},
			{
				slug: "drveni-suveniri",
				naslov: "Drveni suveniri",
				opis: "Ručno izrađeni predmeti od domaćeg drveta.",
				kategorija: {
					label: "Zanat",
					icon: "zanat"
				},
				lokacija: "Teslić",
				slika: img("1773612973407-3b65988ce51a")
			}
		];
		const preporuceno = [
			{
				slug: "med-sa-borja",
				naslov: "Med sa Borja — nagrađeni",
				opis: "Izbor turističke organizacije za 2026.",
				kategorija: {
					label: "Hrana i piće",
					icon: "hrana"
				},
				lokacija: "Borja",
				slika: img("1679941279735-b3b35e8bc476"),
				preporuceno: true
			},
			{
				slug: "banja-vrucica-wellness",
				naslov: "Banja Vrućica — wellness",
				opis: "Termalni bazeni i odmor uz prirodu.",
				kategorija: {
					label: "Smještaj",
					icon: "smjestaj"
				},
				lokacija: "Banja Vrućica",
				slika: img("1498110132731-7a56e6f8ccd7"),
				preporuceno: true
			},
			{
				slug: "etno-selo-borje",
				naslov: "Etno selo Borje",
				opis: "Autentičan smještaj uz domaću kuhinju.",
				kategorija: {
					label: "Smještaj",
					icon: "smjestaj"
				},
				lokacija: "Borje",
				slika: img("1706048085718-622d130a3349"),
				preporuceno: true
			}
		];
		const atrakcije = [
			{
				slug: "banja-vrucica",
				naslov: "Banja Vrućica",
				opis: "Termalni izvori i jedan od najvećih spa centara u BiH.",
				kategorija: {
					label: "Smještaj",
					icon: "smjestaj"
				},
				lokacija: "Vrućica",
				slika: img("1725118342556-6f3ff8588451")
			},
			{
				slug: "planina-borja",
				naslov: "Planina Borja",
				opis: "Šume, planinarske staze i vidikovci.",
				kategorija: {
					label: "Priroda",
					icon: "priroda"
				},
				lokacija: "Borja",
				slika: img("1621766299596-2637f1bf6eb9")
			},
			{
				slug: "vrh-ocaus",
				naslov: "Vrh Očauš",
				opis: "Najviši vrh kraja s panoramskim pogledom.",
				kategorija: {
					label: "Priroda",
					icon: "priroda"
				},
				lokacija: "Očauš",
				slika: img("1503293317069-f8ea8304b4f9")
			},
			{
				slug: "stari-grad",
				naslov: "Stari grad",
				opis: "Tragovi prošlosti teslićkog kraja.",
				kategorija: {
					label: "Kultura",
					icon: "kultura"
				},
				lokacija: "Teslić",
				slika: img("1632945167111-57cde0a03df2")
			}
		];
		const dogadjaji = [
			{
				slug: "ljetni-festival-2026",
				naslov: "Ljetni festival Teslić 2026",
				dan: "12",
				mjesec: "JUL",
				vrijeme: "19:00",
				lokacija: "Centar Teslića",
				slika: img("1781595452029-400aef872fb0")
			},
			{
				slug: "sajam-domacih-proizvoda",
				naslov: "Sajam domaćih proizvoda",
				dan: "20",
				mjesec: "JUL",
				vrijeme: "10:00",
				lokacija: "Banja Vrućica",
				slika: img("1757609908147-440f77e2af25")
			},
			{
				slug: "planinarski-uspon-ocaus",
				naslov: "Planinarski uspon na Očauš",
				dan: "03",
				mjesec: "AVG",
				vrijeme: "08:00",
				lokacija: "Borja",
				slika: img("1547203928-d8c7cc83e56f")
			},
			{
				slug: "vece-folklora",
				naslov: "Veče folklora",
				dan: "15",
				mjesec: "AVG",
				vrijeme: "20:00",
				lokacija: "Vrućica",
				slika: img("1741376478037-80ae743ace47")
			}
		];
		const price = [
			{
				slug: "kako-nastaje-med-sa-borja",
				naslov: "Kako nastaje med sa Borja",
				kategorija: {
					label: "Domaćini pričaju",
					icon: "book-open"
				},
				autor: "Marko P.",
				datum: "10.06.2026.",
				izvod: "Priča pčelara o životu uz košnice na planini.",
				slika: img("1736578147442-503d594222b4")
			},
			{
				slug: "banja-vrucica-kroz-generacije",
				naslov: "Banja Vrućica kroz generacije",
				kategorija: {
					label: "Ljudi i biznisi",
					icon: "book-open"
				},
				autor: "Jelena S.",
				datum: "02.06.2026.",
				izvod: "Porodična tradicija banjskog turizma.",
				slika: img("1774876549411-52e4eaff626e")
			},
			{
				slug: "jedan-dan-na-ocausu",
				naslov: "Jedan dan na Očaušu",
				kategorija: {
					label: "Naša svakodnevica",
					icon: "book-open"
				},
				autor: "Nikola T.",
				datum: "28.05.2026.",
				izvod: "Uspon, pogled i tišina najvišeg vrha.",
				slika: img("1706195292026-ae27145ff403")
			}
		];
		const galerija = [
			img("1652552888460-334e60915994"),
			img("1611458182018-c043f4e947ec"),
			img("1654156109213-00399ebbd802"),
			img("1725118345125-3ceaa0599620")
		];
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<!--[--><section class="bg-surface py-8 md:py-12">`);
			_push(ssrRenderComponent(_sfc_main$98, null, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="relative min-h-[420px] overflow-hidden rounded-2xl bg-primary-darker"${_scopeId}><img${ssrRenderAttr("src", unref(heroImg))} alt="" class="absolute inset-0 size-full object-cover"${_scopeId}><div class="absolute inset-0" style="${ssrRenderStyle({ "background-color": "#0a2c27cc" })}"${_scopeId}></div><div class="relative max-w-[620px] px-8 py-16 md:px-14 md:py-24"${_scopeId}><p class="text-sm font-semibold uppercase tracking-[0.1em] text-secondary"${_scopeId}> Dobrodošli u Teslić </p><h1 class="mt-4 font-heading text-[32px] font-bold leading-[1.12] text-white md:text-[46px]"${_scopeId}> Teslić — domaće, autentično, blizu </h1><p class="mt-4 max-w-[560px] text-base text-primary-tint md:text-lg"${_scopeId}> Termalna Banja Vrućica, planine Borja i Očauš, domaći proizvodi i ljudi koji ih prave — sve na jednom mjestu. </p><div class="mt-6 flex flex-wrap gap-3"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "sekundarna",
							icon: "sparkles"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Istraži ponudu`);
								else return [createTextVNode("Istraži ponudu")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(unref(Link), {
							href: "/pridruzi-se",
							class: "inline-flex h-11 items-center justify-center rounded-sm border-[1.5px] border-white px-5 font-semibold text-white transition-colors hover:bg-white/10"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Pridruži se `);
								else return [createTextVNode(" Pridruži se ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div></div></div>`);
					} else return [createVNode("div", { class: "relative min-h-[420px] overflow-hidden rounded-2xl bg-primary-darker" }, [
						createVNode("img", {
							src: unref(heroImg),
							alt: "",
							class: "absolute inset-0 size-full object-cover"
						}, null, 8, ["src"]),
						createVNode("div", {
							class: "absolute inset-0",
							style: { "background-color": "#0a2c27cc" }
						}),
						createVNode("div", { class: "relative max-w-[620px] px-8 py-16 md:px-14 md:py-24" }, [
							createVNode("p", { class: "text-sm font-semibold uppercase tracking-[0.1em] text-secondary" }, " Dobrodošli u Teslić "),
							createVNode("h1", { class: "mt-4 font-heading text-[32px] font-bold leading-[1.12] text-white md:text-[46px]" }, " Teslić — domaće, autentično, blizu "),
							createVNode("p", { class: "mt-4 max-w-[560px] text-base text-primary-tint md:text-lg" }, " Termalna Banja Vrućica, planine Borja i Očauš, domaći proizvodi i ljudi koji ih prave — sve na jednom mjestu. "),
							createVNode("div", { class: "mt-6 flex flex-wrap gap-3" }, [createVNode(_sfc_main$93, {
								variant: "sekundarna",
								icon: "sparkles"
							}, {
								default: withCtx(() => [createTextVNode("Istraži ponudu")]),
								_: 1
							}), createVNode(unref(Link), {
								href: "/pridruzi-se",
								class: "inline-flex h-11 items-center justify-center rounded-sm border-[1.5px] border-white px-5 font-semibold text-white transition-colors hover:bg-white/10"
							}, {
								default: withCtx(() => [createTextVNode(" Pridruži se ")]),
								_: 1
							})])
						])
					])];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface-alt py-10">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-5" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<h2 class="font-heading text-[22px] font-bold text-heading md:text-[28px]"${_scopeId}> Istražite po kategoriji </h2><div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6"${_scopeId}><!--[-->`);
						ssrRenderList(kategorije, (k) => {
							_push(ssrRenderComponent(unref(Link), {
								key: k.label,
								href: k.href,
								class: "flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-3 py-5 text-center transition-shadow hover:shadow-[var(--shadow-md)]"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) {
										_push(`<span class="flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary"${_scopeId}>`);
										_push(ssrRenderComponent(_sfc_main$97, {
											name: k.icon,
											size: 22
										}, null, _parent, _scopeId));
										_push(`</span><span class="text-sm font-semibold leading-tight text-heading"${_scopeId}>${ssrInterpolate(k.label)}</span>`);
									} else return [createVNode("span", { class: "flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary" }, [createVNode(_sfc_main$97, {
										name: k.icon,
										size: 22
									}, null, 8, ["name"])]), createVNode("span", { class: "text-sm font-semibold leading-tight text-heading" }, toDisplayString(k.label), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
						});
						_push(`<!--]--></div>`);
					} else return [createVNode("h2", { class: "font-heading text-[22px] font-bold text-heading md:text-[28px]" }, " Istražite po kategoriji "), createVNode("div", { class: "grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6" }, [(openBlock(), createBlock(Fragment, null, renderList(kategorije, (k) => {
						return createVNode(unref(Link), {
							key: k.label,
							href: k.href,
							class: "flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-3 py-5 text-center transition-shadow hover:shadow-[var(--shadow-md)]"
						}, {
							default: withCtx(() => [createVNode("span", { class: "flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary" }, [createVNode(_sfc_main$97, {
								name: k.icon,
								size: 22
							}, null, 8, ["name"])]), createVNode("span", { class: "text-sm font-semibold leading-tight text-heading" }, toDisplayString(k.label), 1)]),
							_: 2
						}, 1032, ["href"]);
					}), 64))])];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: "Lokalni proizvodi i usluge",
							"link-text": "Vidi sve",
							to: "/domace-je-najbolje"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$90, null, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(proizvodi, (p) => {
										_push(ssrRenderComponent(_sfc_main$70, {
											key: p.slug,
											item: p
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(proizvodi, (p) => {
									return createVNode(_sfc_main$70, {
										key: p.slug,
										item: p
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
					} else return [createVNode(_sfc_main$47, {
						title: "Lokalni proizvodi i usluge",
						"link-text": "Vidi sve",
						to: "/domace-je-najbolje"
					}), createVNode(_sfc_main$90, null, {
						default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(proizvodi, (p) => {
							return createVNode(_sfc_main$70, {
								key: p.slug,
								item: p
							}, null, 8, ["item"]);
						}), 64))]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-primary-tint py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: "Preporučeno iz prve ruke",
							"link-text": "Vidi sve",
							to: "/domace-je-najbolje"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(preporuceno, (p) => {
										_push(ssrRenderComponent(_sfc_main$70, {
											key: p.slug,
											item: p
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(preporuceno, (p) => {
									return createVNode(_sfc_main$70, {
										key: p.slug,
										item: p
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
					} else return [createVNode(_sfc_main$47, {
						title: "Preporučeno iz prve ruke",
						"link-text": "Vidi sve",
						to: "/domace-je-najbolje"
					}), createVNode(_sfc_main$90, { cols: 3 }, {
						default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(preporuceno, (p) => {
							return createVNode(_sfc_main$70, {
								key: p.slug,
								item: p
							}, null, 8, ["item"]);
						}), 64))]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: "Turističke atrakcije",
							"link-text": "Vidi sve",
							to: "/turizam"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$90, null, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(atrakcije, (a) => {
										_push(ssrRenderComponent(_sfc_main$70, {
											key: a.slug,
											item: a,
											to: `/turizam/${a.slug}`
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(atrakcije, (a) => {
									return createVNode(_sfc_main$70, {
										key: a.slug,
										item: a,
										to: `/turizam/${a.slug}`
									}, null, 8, ["item", "to"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
					} else return [createVNode(_sfc_main$47, {
						title: "Turističke atrakcije",
						"link-text": "Vidi sve",
						to: "/turizam"
					}), createVNode(_sfc_main$90, null, {
						default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(atrakcije, (a) => {
							return createVNode(_sfc_main$70, {
								key: a.slug,
								item: a,
								to: `/turizam/${a.slug}`
							}, null, 8, ["item", "to"]);
						}), 64))]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface-alt py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: "Istraži na mapi",
							"link-text": "Otvori mapu",
							to: "/mapa"
						}, null, _parent, _scopeId));
						_push(`<div class="flex h-[340px] flex-col items-center justify-center gap-4 rounded-2xl bg-primary-tint px-4 text-center"${_scopeId}><span class="flex size-16 items-center justify-center rounded-full bg-surface text-primary"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "map-pin",
							size: 30
						}, null, _parent, _scopeId));
						_push(`</span><p class="text-xl font-semibold text-heading"${_scopeId}>Interaktivna mapa turističke ponude</p>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							to: "/mapa",
							variant: "primary",
							icon: "map"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Otvori mapu`);
								else return [createTextVNode("Otvori mapu")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div>`);
					} else return [createVNode(_sfc_main$47, {
						title: "Istraži na mapi",
						"link-text": "Otvori mapu",
						to: "/mapa"
					}), createVNode("div", { class: "flex h-[340px] flex-col items-center justify-center gap-4 rounded-2xl bg-primary-tint px-4 text-center" }, [
						createVNode("span", { class: "flex size-16 items-center justify-center rounded-full bg-surface text-primary" }, [createVNode(_sfc_main$97, {
							name: "map-pin",
							size: 30
						})]),
						createVNode("p", { class: "text-xl font-semibold text-heading" }, "Interaktivna mapa turističke ponude"),
						createVNode(_sfc_main$93, {
							to: "/mapa",
							variant: "primary",
							icon: "map"
						}, {
							default: withCtx(() => [createTextVNode("Otvori mapu")]),
							_: 1
						})
					])];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: "Nadolazeći događaji",
							"link-text": "Kalendar",
							to: "/dogadjaji"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$90, null, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(dogadjaji, (d) => {
										_push(ssrRenderComponent(_sfc_main$62, {
											key: d.slug,
											item: d
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(dogadjaji, (d) => {
									return createVNode(_sfc_main$62, {
										key: d.slug,
										item: d
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
					} else return [createVNode(_sfc_main$47, {
						title: "Nadolazeći događaji",
						"link-text": "Kalendar",
						to: "/dogadjaji"
					}), createVNode(_sfc_main$90, null, {
						default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(dogadjaji, (d) => {
							return createVNode(_sfc_main$62, {
								key: d.slug,
								item: d
							}, null, 8, ["item"]);
						}), 64))]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface-alt py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: "Priče iz Teslića",
							"link-text": "Sve priče",
							to: "/price"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(price, (s) => {
										_push(ssrRenderComponent(_sfc_main$61, {
											key: s.slug,
											item: s
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(), createBlock(Fragment, null, renderList(price, (s) => {
									return createVNode(_sfc_main$61, {
										key: s.slug,
										item: s
									}, null, 8, ["item"]);
								}), 64))];
							}),
							_: 1
						}, _parent, _scopeId));
					} else return [createVNode(_sfc_main$47, {
						title: "Priče iz Teslića",
						"link-text": "Sve priče",
						to: "/price"
					}), createVNode(_sfc_main$90, { cols: 3 }, {
						default: withCtx(() => [(openBlock(), createBlock(Fragment, null, renderList(price, (s) => {
							return createVNode(_sfc_main$61, {
								key: s.slug,
								item: s
							}, null, 8, ["item"]);
						}), 64))]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: "Galerija",
							"link-text": "Vidi sve",
							to: "/price"
						}, null, _parent, _scopeId));
						_push(`<div class="grid grid-cols-2 gap-4 lg:grid-cols-4"${_scopeId}><!--[-->`);
						ssrRenderList(galerija, (g, i) => {
							_push(`<img${ssrRenderAttr("src", g)} alt="" loading="lazy" class="h-[220px] w-full rounded-md object-cover"${_scopeId}>`);
						});
						_push(`<!--]--></div>`);
					} else return [createVNode(_sfc_main$47, {
						title: "Galerija",
						"link-text": "Vidi sve",
						to: "/price"
					}), createVNode("div", { class: "grid grid-cols-2 gap-4 lg:grid-cols-4" }, [(openBlock(), createBlock(Fragment, null, renderList(galerija, (g, i) => {
						return createVNode("img", {
							key: i,
							src: g,
							alt: "",
							loading: "lazy",
							class: "h-[220px] w-full rounded-md object-cover"
						}, null, 8, ["src"]);
					}), 64))])];
				}),
				_: 1
			}, _parent));
			_push(`</section><section class="bg-surface py-12 md:py-16">`);
			_push(ssrRenderComponent(_sfc_main$98, null, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$94, {
						title: "Pridružite se platformi Teslić",
						text: "Predstavite svoj biznis hiljadama posjetilaca ili podijelite svoju priču o teslićkom kraju."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) {
								_push(ssrRenderComponent(_sfc_main$93, { variant: "sekundarna" }, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(`Registruj biznis`);
										else return [createTextVNode("Registruj biznis")];
									}),
									_: 1
								}, _parent, _scopeId));
								_push(ssrRenderComponent(_sfc_main$93, { variant: "secondary" }, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(`Postani autor`);
										else return [createTextVNode("Postani autor")];
									}),
									_: 1
								}, _parent, _scopeId));
							} else return [createVNode(_sfc_main$93, { variant: "sekundarna" }, {
								default: withCtx(() => [createTextVNode("Registruj biznis")]),
								_: 1
							}), createVNode(_sfc_main$93, { variant: "secondary" }, {
								default: withCtx(() => [createTextVNode("Postani autor")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$94, {
						title: "Pridružite se platformi Teslić",
						text: "Predstavite svoj biznis hiljadama posjetilaca ili podijelite svoju priču o teslićkom kraju."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, { variant: "sekundarna" }, {
							default: withCtx(() => [createTextVNode("Registruj biznis")]),
							_: 1
						}), createVNode(_sfc_main$93, { variant: "secondary" }, {
							default: withCtx(() => [createTextVNode("Postani autor")]),
							_: 1
						})]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			_push(`</section><!--]-->`);
		};
	}
};
var _sfc_setup$46 = _sfc_main$46.setup;
_sfc_main$46.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Home.vue");
	return _sfc_setup$46 ? _sfc_setup$46(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/common/PagePlaceholder.vue
var _sfc_main$45 = {
	__name: "PagePlaceholder",
	__ssrInlineRender: true,
	props: {
		title: {
			type: String,
			required: true
		},
		phase: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "py-12 md:py-16"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						if (__props.phase) _push(`<p class="text-sm font-medium uppercase tracking-wide text-primary"${_scopeId}>${ssrInterpolate(__props.phase)}</p>`);
						else _push(`<!---->`);
						_push(`<h1 class="mt-2 text-3xl font-bold text-heading md:text-4xl"${_scopeId}>${ssrInterpolate(__props.title)}</h1><p class="mt-3 max-w-prose text-text-muted"${_scopeId}> Stranica je u izradi prema planu (<code${_scopeId}>specifikacija/frontend/</code>). </p>`);
						ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent, _scopeId);
					} else return [
						__props.phase ? (openBlock(), createBlock("p", {
							key: 0,
							class: "text-sm font-medium uppercase tracking-wide text-primary"
						}, toDisplayString(__props.phase), 1)) : createCommentVNode("", true),
						createVNode("h1", { class: "mt-2 text-3xl font-bold text-heading md:text-4xl" }, toDisplayString(__props.title), 1),
						createVNode("p", { class: "mt-3 max-w-prose text-text-muted" }, [
							createTextVNode(" Stranica je u izradi prema planu ("),
							createVNode("code", null, "specifikacija/frontend/"),
							createTextVNode("). ")
						]),
						renderSlot(_ctx.$slots, "default")
					];
				}),
				_: 3
			}, _parent));
		};
	}
};
var _sfc_setup$45 = _sfc_main$45.setup;
_sfc_main$45.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/common/PagePlaceholder.vue");
	return _sfc_setup$45 ? _sfc_setup$45(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/JoinHub.vue
var JoinHub_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$44 });
var _sfc_main$44 = {
	__name: "JoinHub",
	__ssrInlineRender: true,
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$45, mergeProps({
				title: "Pridruži se",
				phase: "Faza F10"
			}, _attrs), null, _parent));
		};
	}
};
var _sfc_setup$44 = _sfc_main$44.setup;
_sfc_main$44.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/JoinHub.vue");
	return _sfc_setup$44 ? _sfc_setup$44(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Legal.vue
var Legal_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$43 });
var _sfc_main$43 = {
	__name: "Legal",
	__ssrInlineRender: true,
	props: { doc: {
		type: String,
		default: "privatnost"
	} },
	setup(__props) {
		const props = __props;
		const dokumenti = {
			privatnost: {
				naslov: "Politika privatnosti",
				uvod: "Ova politika opisuje kako platforma turističke ponude Teslić prikuplja, koristi i štiti lične podatke korisnika.",
				sekcije: [
					{
						h: "Koje podatke prikupljamo",
						p: "Prikupljamo podatke koje nam dobrovoljno dostavite putem kontakt forme ili prilikom registracije biznisa ili autorskog naloga (ime, e-mail adresa, kontakt podaci) te osnovne tehničke podatke o korištenju platforme."
					},
					{
						h: "Svrha obrade",
						p: "Podatke koristimo isključivo radi odgovaranja na upite, objavljivanja i upravljanja sadržajem koji ste prijavili te poboljšanja rada platforme."
					},
					{
						h: "Čuvanje i dijeljenje",
						p: "Podatke čuvamo onoliko dugo koliko je potrebno za navedene svrhe i ne dijelimo ih s trećim stranama osim kada to nalaže zakon."
					},
					{
						h: "Vaša prava",
						p: "Imate pravo na pristup, ispravak i brisanje svojih podataka. Za ostvarivanje ovih prava obratite nam se putem kontakt forme."
					}
				]
			},
			kolacici: {
				naslov: "Politika kolačića",
				uvod: "Platforma koristi kolačiće (cookies) kako bi osigurala ispravan rad i bolje korisničko iskustvo.",
				sekcije: [
					{
						h: "Šta su kolačići",
						p: "Kolačići su male tekstualne datoteke koje se pohranjuju na vašem uređaju prilikom posjete web stranici."
					},
					{
						h: "Vrste kolačića koje koristimo",
						p: "Koristimo neophodne kolačiće za osnovne funkcije platforme te analitičke kolačiće za razumijevanje načina korištenja sadržaja."
					},
					{
						h: "Upravljanje kolačićima",
						p: "Kolačiće možete u svakom trenutku onemogućiti ili obrisati u postavkama svog internet pregledača. Napominjemo da to može uticati na funkcionalnost platforme."
					}
				]
			},
			uslovi: {
				naslov: "Uslovi korištenja",
				uvod: "Korištenjem platforme turističke ponude Teslić prihvatate sljedeće uslove korištenja.",
				sekcije: [
					{
						h: "Korištenje sadržaja",
						p: "Sadržaj platforme namijenjen je informisanju posjetilaca o turističkoj i privrednoj ponudi Teslića. Zabranjena je zloupotreba sadržaja u nezakonite svrhe."
					},
					{
						h: "Objava sadržaja",
						p: "Korisnici koji objavljuju sadržaj (biznisi, autori) odgovorni su za tačnost i zakonitost objavljenih informacija. Administrator zadržava pravo pregleda i uklanjanja neprimjerenog sadržaja."
					},
					{
						h: "Odgovornost",
						p: "Platforma se trudi osigurati tačnost informacija, ali ne preuzima odgovornost za eventualne greške ili promjene u ponudi pojedinih subjekata."
					},
					{
						h: "Izmjene uslova",
						p: "Zadržavamo pravo izmjene ovih uslova. Aktuelna verzija uvijek je dostupna na ovoj stranici."
					}
				]
			}
		};
		const dok = computed(() => dokumenti[props.doc] || dokumenti.privatnost);
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: dok.value.naslov }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: dok.value.naslov }] }, null, 8, ["items"])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<article class="max-w-3xl"${_scopeId}><h1 class="font-heading text-3xl font-bold text-heading md:text-4xl"${_scopeId}>${ssrInterpolate(dok.value.naslov)}</h1><p class="mt-4 text-lg text-text-muted"${_scopeId}>${ssrInterpolate(dok.value.uvod)}</p><!--[-->`);
						ssrRenderList(dok.value.sekcije, (sekcija) => {
							_push(`<section class="mt-8"${_scopeId}><h2 class="font-heading text-xl font-semibold text-heading"${_scopeId}>${ssrInterpolate(sekcija.h)}</h2><p class="mt-3 text-text-muted"${_scopeId}>${ssrInterpolate(sekcija.p)}</p></section>`);
						});
						_push(`<!--]--><p class="mt-10 text-sm text-text-muted"${_scopeId}> Napomena: ovo je preliminarni tekst i bit će dopunjen konačnom pravnom verzijom. </p></article>`);
					} else return [createVNode("article", { class: "max-w-3xl" }, [
						createVNode("h1", { class: "font-heading text-3xl font-bold text-heading md:text-4xl" }, toDisplayString(dok.value.naslov), 1),
						createVNode("p", { class: "mt-4 text-lg text-text-muted" }, toDisplayString(dok.value.uvod), 1),
						(openBlock(true), createBlock(Fragment, null, renderList(dok.value.sekcije, (sekcija) => {
							return openBlock(), createBlock("section", {
								key: sekcija.h,
								class: "mt-8"
							}, [createVNode("h2", { class: "font-heading text-xl font-semibold text-heading" }, toDisplayString(sekcija.h), 1), createVNode("p", { class: "mt-3 text-text-muted" }, toDisplayString(sekcija.p), 1)]);
						}), 128)),
						createVNode("p", { class: "mt-10 text-sm text-text-muted" }, " Napomena: ovo je preliminarni tekst i bit će dopunjen konačnom pravnom verzijom. ")
					])];
				}),
				_: 1
			}, _parent));
			_push(`</main>`);
		};
	}
};
var _sfc_setup$43 = _sfc_main$43.setup;
_sfc_main$43.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Legal.vue");
	return _sfc_setup$43 ? _sfc_setup$43(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/LocalListing.vue
var LocalListing_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$42 });
var PO_STRANICI$2 = 8;
var _sfc_main$42 = {
	__name: "LocalListing",
	__ssrInlineRender: true,
	props: { biznisi: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		const props = __props;
		const data = computed(() => props.biznisi);
		const upit = ref("");
		const kategorija = ref("");
		const stranica = ref(1);
		const kategorijeOpcije = [
			{
				value: "zanat",
				label: "Zanatski proizvodi"
			},
			{
				value: "hrana",
				label: "Domaća hrana i piće"
			},
			{
				value: "usluge",
				label: "Usluge i servisi"
			}
		];
		const filtrirano = computed(() => {
			let lista = data.value || [];
			if (kategorija.value) lista = lista.filter((b) => b.kategorija?.icon === kategorija.value);
			if (upit.value.trim()) {
				const q = upit.value.trim().toLowerCase();
				lista = lista.filter((b) => b.naslov?.toLowerCase().includes(q) || b.opis?.toLowerCase().includes(q) || b.lokacija?.toLowerCase().includes(q));
			}
			return lista;
		});
		const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI$2)));
		const vidljivi = computed(() => filtrirano.value.slice((stranica.value - 1) * PO_STRANICI$2, stranica.value * PO_STRANICI$2));
		const aktivniChipovi = computed(() => {
			const chips = [];
			if (kategorija.value) {
				const k = kategorijeOpcije.find((o) => o.value === kategorija.value);
				chips.push({
					key: "kategorija",
					label: k ? k.label : kategorija.value
				});
			}
			if (upit.value.trim()) chips.push({
				key: "upit",
				label: `„${upit.value.trim()}”`
			});
			return chips;
		});
		watch([kategorija, upit], () => {
			stranica.value = 1;
		});
		function ocisti() {
			kategorija.value = "";
			upit.value = "";
		}
		function ukloni(key) {
			if (key === "kategorija") kategorija.value = "";
			if (key === "upit") upit.value = "";
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$96, {
				variant: "split",
				kicker: "Domaće je najbolje",
				title: "Lokalni proizvodi i usluge",
				subtitle: "Otkrijte zanate, domaću hranu i piće te pouzdane usluge iz Teslića i okoline."
			}, null, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Domaće je najbolje" }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Domaće je najbolje" }] })];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) {
								_push(ssrRenderComponent(_sfc_main$78, {
									modelValue: kategorija.value,
									"onUpdate:modelValue": ($event) => kategorija.value = $event,
									options: kategorijeOpcije,
									placeholder: "Sve kategorije"
								}, null, _parent, _scopeId));
								_push(ssrRenderComponent(_sfc_main$79, {
									modelValue: upit.value,
									"onUpdate:modelValue": ($event) => upit.value = $event,
									placeholder: "Pretraži ponudu…"
								}, null, _parent, _scopeId));
							} else return [createVNode(_sfc_main$78, {
								modelValue: kategorija.value,
								"onUpdate:modelValue": ($event) => kategorija.value = $event,
								options: kategorijeOpcije,
								placeholder: "Sve kategorije"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
								modelValue: upit.value,
								"onUpdate:modelValue": ($event) => upit.value = $event,
								placeholder: "Pretraži ponudu…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx(() => [createVNode(_sfc_main$78, {
							modelValue: kategorija.value,
							"onUpdate:modelValue": ($event) => kategorija.value = $event,
							options: kategorijeOpcije,
							placeholder: "Sve kategorije"
						}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
							modelValue: upit.value,
							"onUpdate:modelValue": ($event) => upit.value = $event,
							placeholder: "Pretraži ponudu…"
						}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
						_: 1
					}, 8, ["chips"])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!vidljivi.value.length) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Nema rezultata",
						text: "Za odabrane filtere nema ponude. Pokušajte promijeniti kategoriju ili pretragu."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ocisti
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`Očisti filtere`);
									else return [createTextVNode("Očisti filtere")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ocisti
							}, {
								default: withCtx(() => [createTextVNode("Očisti filtere")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$90, null, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(vidljivi.value, (b) => {
										_push(ssrRenderComponent(_sfc_main$70, {
											key: b.slug,
											item: b
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (b) => {
									return openBlock(), createBlock(_sfc_main$70, {
										key: b.slug,
										item: b
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						if (ukupnoStranica.value > 1) {
							_push(`<div class="mt-10 flex justify-center"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$77, {
								modelValue: stranica.value,
								"onUpdate:modelValue": ($event) => stranica.value = $event,
								total: ukupnoStranica.value
							}, null, _parent, _scopeId));
							_push(`</div>`);
						} else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!vidljivi.value.length ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Nema rezultata",
						text: "Za odabrane filtere nema ponude. Pokušajte promijeniti kategoriju ili pretragu."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							size: "sm",
							onClick: ocisti
						}, {
							default: withCtx(() => [createTextVNode("Očisti filtere")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [createVNode(_sfc_main$90, null, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (b) => {
							return openBlock(), createBlock(_sfc_main$70, {
								key: b.slug,
								item: b
							}, null, 8, ["item"]);
						}), 128))]),
						_: 1
					}), ukupnoStranica.value > 1 ? (openBlock(), createBlock("div", {
						key: 0,
						class: "mt-10 flex justify-center"
					}, [createVNode(_sfc_main$77, {
						modelValue: stranica.value,
						"onUpdate:modelValue": ($event) => stranica.value = $event,
						total: ukupnoStranica.value
					}, null, 8, [
						"modelValue",
						"onUpdate:modelValue",
						"total"
					])])) : createCommentVNode("", true)], 64))];
				}),
				_: 1
			}, _parent));
			_push(`</main>`);
		};
	}
};
var _sfc_setup$42 = _sfc_main$42.setup;
_sfc_main$42.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/LocalListing.vue");
	return _sfc_setup$42 ? _sfc_setup$42(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/LocationDetail.vue
var LocationDetail_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$41 });
var _sfc_main$41 = {
	__name: "LocationDetail",
	__ssrInlineRender: true,
	props: {
		slug: {
			type: String,
			default: ""
		},
		lokalitet: {
			type: Object,
			default: null
		},
		slicni: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const lokalitet = computed(() => props.lokalitet);
		const slicni = computed(() => props.slicni);
		const infoItems = computed(() => {
			if (!lokalitet.value) return [];
			const l = lokalitet.value;
			const items = [];
			if (l.kategorija?.label) items.push({
				icon: l.kategorija.icon || "tag",
				label: "Tip",
				value: l.kategorija.label
			});
			if (l.sezona) items.push({
				icon: "calendar",
				label: "Sezona",
				value: l.sezona
			});
			if (l.radnoVrijeme) items.push({
				icon: "clock",
				label: "Radno vrijeme",
				value: l.radnoVrijeme
			});
			if (l.ulaznice) items.push({
				icon: "ticket",
				label: "Ulaznice",
				value: l.ulaznice
			});
			if (l.lokacija) items.push({
				icon: "map-pin",
				label: "Lokacija",
				value: l.lokacija
			});
			return items;
		});
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "py-8"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!lokalitet.value) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Lokalitet nije pronađen",
						text: "Traženi lokalitet ne postoji ili je uklonjen."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/turizam"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Nazad na turizam `);
									else return [createTextVNode(" Nazad na turizam ")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/turizam"
							}, {
								default: withCtx(() => [createTextVNode(" Nazad na turizam ")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Turizam u Tesliću",
								to: "/turizam"
							},
							{ label: lokalitet.value.naslov }
						] }, null, _parent, _scopeId));
						_push(`<div class="mt-6 overflow-hidden rounded-lg"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: lokalitet.value.kategorija?.label,
							title: lokalitet.value.naslov,
							subtitle: lokalitet.value.opis,
							image: lokalitet.value.slika
						}, null, _parent, _scopeId));
						_push(`</div>`);
						if (lokalitet.value.galerija?.length) {
							_push(`<section class="mt-10"${_scopeId}><h2 class="mb-4 font-heading text-2xl font-bold text-heading"${_scopeId}>Galerija</h2>`);
							_push(ssrRenderComponent(_sfc_main$73, { items: lokalitet.value.galerija }, null, _parent, _scopeId));
							_push(`</section>`);
						} else _push(`<!---->`);
						_push(`<div class="mt-10 grid gap-8 lg:grid-cols-3"${_scopeId}><div class="space-y-8 lg:col-span-2"${_scopeId}>`);
						if (lokalitet.value.opisDug) _push(`<section${_scopeId}><h2 class="mb-3 font-heading text-2xl font-bold text-heading"${_scopeId}>O lokaciji</h2><p class="whitespace-pre-line leading-relaxed text-text"${_scopeId}>${ssrInterpolate(lokalitet.value.opisDug)}</p></section>`);
						else _push(`<!---->`);
						if (lokalitet.value.kakoDoci) _push(`<section${_scopeId}><h2 class="mb-3 font-heading text-2xl font-bold text-heading"${_scopeId}>Kako doći</h2><p class="whitespace-pre-line leading-relaxed text-text"${_scopeId}>${ssrInterpolate(lokalitet.value.kakoDoci)}</p></section>`);
						else _push(`<!---->`);
						if (lokalitet.value.savjeti) _push(`<section${_scopeId}><h2 class="mb-3 font-heading text-2xl font-bold text-heading"${_scopeId}>Savjeti</h2><p class="whitespace-pre-line leading-relaxed text-text"${_scopeId}>${ssrInterpolate(lokalitet.value.savjeti)}</p></section>`);
						else _push(`<!---->`);
						_push(`</div><div class="space-y-6"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$91, {
							title: "Informacije",
							items: infoItems.value
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$72, { label: lokalitet.value.lokacija }, null, _parent, _scopeId));
						_push(`</div></div>`);
						if (slicni.value.length) _push(ssrRenderComponent(_sfc_main$89, { title: "Slični lokaliteti" }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(slicni.value, (l) => {
										_push(ssrRenderComponent(_sfc_main$63, {
											key: l.slug,
											item: l
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (l) => {
									return openBlock(), createBlock(_sfc_main$63, {
										key: l.slug,
										item: l
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!lokalitet.value ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Lokalitet nije pronađen",
						text: "Traženi lokalitet ne postoji ili je uklonjen."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "arrow-left",
							to: "/turizam"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na turizam ")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [
						createVNode(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Turizam u Tesliću",
								to: "/turizam"
							},
							{ label: lokalitet.value.naslov }
						] }, null, 8, ["items"]),
						createVNode("div", { class: "mt-6 overflow-hidden rounded-lg" }, [createVNode(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: lokalitet.value.kategorija?.label,
							title: lokalitet.value.naslov,
							subtitle: lokalitet.value.opis,
							image: lokalitet.value.slika
						}, null, 8, [
							"kicker",
							"title",
							"subtitle",
							"image"
						])]),
						lokalitet.value.galerija?.length ? (openBlock(), createBlock("section", {
							key: 0,
							class: "mt-10"
						}, [createVNode("h2", { class: "mb-4 font-heading text-2xl font-bold text-heading" }, "Galerija"), createVNode(_sfc_main$73, { items: lokalitet.value.galerija }, null, 8, ["items"])])) : createCommentVNode("", true),
						createVNode("div", { class: "mt-10 grid gap-8 lg:grid-cols-3" }, [createVNode("div", { class: "space-y-8 lg:col-span-2" }, [
							lokalitet.value.opisDug ? (openBlock(), createBlock("section", { key: 0 }, [createVNode("h2", { class: "mb-3 font-heading text-2xl font-bold text-heading" }, "O lokaciji"), createVNode("p", { class: "whitespace-pre-line leading-relaxed text-text" }, toDisplayString(lokalitet.value.opisDug), 1)])) : createCommentVNode("", true),
							lokalitet.value.kakoDoci ? (openBlock(), createBlock("section", { key: 1 }, [createVNode("h2", { class: "mb-3 font-heading text-2xl font-bold text-heading" }, "Kako doći"), createVNode("p", { class: "whitespace-pre-line leading-relaxed text-text" }, toDisplayString(lokalitet.value.kakoDoci), 1)])) : createCommentVNode("", true),
							lokalitet.value.savjeti ? (openBlock(), createBlock("section", { key: 2 }, [createVNode("h2", { class: "mb-3 font-heading text-2xl font-bold text-heading" }, "Savjeti"), createVNode("p", { class: "whitespace-pre-line leading-relaxed text-text" }, toDisplayString(lokalitet.value.savjeti), 1)])) : createCommentVNode("", true)
						]), createVNode("div", { class: "space-y-6" }, [createVNode(_sfc_main$91, {
							title: "Informacije",
							items: infoItems.value
						}, null, 8, ["items"]), createVNode(_sfc_main$72, { label: lokalitet.value.lokacija }, null, 8, ["label"])])]),
						slicni.value.length ? (openBlock(), createBlock(_sfc_main$89, {
							key: 1,
							title: "Slični lokaliteti"
						}, {
							default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(slicni.value, (l) => {
								return openBlock(), createBlock(_sfc_main$63, {
									key: l.slug,
									item: l
								}, null, 8, ["item"]);
							}), 128))]),
							_: 1
						})) : createCommentVNode("", true)
					], 64))];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$41 = _sfc_main$41.setup;
_sfc_main$41.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/LocationDetail.vue");
	return _sfc_setup$41 ? _sfc_setup$41(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Login.vue
var Login_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$40 });
var _sfc_main$40 = {
	__name: "Login",
	__ssrInlineRender: true,
	setup(__props) {
		const page = usePage();
		const status = computed(() => page.props.flash?.status);
		const form = useForm({
			email: "",
			password: "",
			remember: false
		});
		function submit() {
			form.post("/login", { onFinish: () => form.reset("password") });
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<section${ssrRenderAttrs(mergeProps({ class: "bg-surface-alt" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "flex min-h-[600px] items-center justify-center py-16" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8"${_scopeId}><h1 class="font-heading text-2xl font-bold text-heading"${_scopeId}>Prijava</h1>`);
						if (status.value) {
							_push(`<div class="flex gap-3 rounded-md bg-info-tint p-4 text-sm text-info" role="status"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: "clock-3",
								size: 20,
								class: "mt-0.5 shrink-0"
							}, null, _parent, _scopeId));
							_push(`<span${_scopeId}>${ssrInterpolate(status.value)}</span></div>`);
						} else _push(`<!---->`);
						if (unref(form).errors.email) {
							_push(`<div class="flex gap-2.5 rounded-md bg-error-tint p-3.5 text-sm text-error" role="alert"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: "circle-alert",
								size: 20,
								class: "mt-0.5 shrink-0"
							}, null, _parent, _scopeId));
							_push(`<span${_scopeId}>${ssrInterpolate(unref(form).errors.email)}</span></div>`);
						} else _push(`<!---->`);
						_push(`<form class="space-y-5"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).email,
							"onUpdate:modelValue": ($event) => unref(form).email = $event,
							label: "E-mail",
							type: "email",
							placeholder: "marko@primjer.ba"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).password,
							"onUpdate:modelValue": ($event) => unref(form).password = $event,
							label: "Lozinka",
							type: "password",
							placeholder: "••••••••"
						}, null, _parent, _scopeId));
						_push(`<div class="flex items-center justify-between"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$66, {
							modelValue: unref(form).remember,
							"onUpdate:modelValue": ($event) => unref(form).remember = $event,
							label: "Zapamti me"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(unref(Link), {
							href: "/zaboravljena-lozinka",
							class: "text-sm font-medium text-primary hover:underline"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Zaboravljena lozinka? `);
								else return [createTextVNode(" Zaboravljena lozinka? ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							type: "submit",
							variant: "primary",
							block: "",
							disabled: unref(form).processing
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Prijava `);
								else return [createTextVNode(" Prijava ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</form><hr class="border-border"${_scopeId}><p class="text-center text-sm text-text-muted"${_scopeId}> Nemaš nalog? `);
						_push(ssrRenderComponent(unref(Link), {
							href: "/registracija",
							class: "font-semibold text-primary hover:underline"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Pridruži se `);
								else return [createTextVNode(" Pridruži se ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</p></div>`);
					} else return [createVNode("div", { class: "w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8" }, [
						createVNode("h1", { class: "font-heading text-2xl font-bold text-heading" }, "Prijava"),
						status.value ? (openBlock(), createBlock("div", {
							key: 0,
							class: "flex gap-3 rounded-md bg-info-tint p-4 text-sm text-info",
							role: "status"
						}, [createVNode(_sfc_main$97, {
							name: "clock-3",
							size: 20,
							class: "mt-0.5 shrink-0"
						}), createVNode("span", null, toDisplayString(status.value), 1)])) : createCommentVNode("", true),
						unref(form).errors.email ? (openBlock(), createBlock("div", {
							key: 1,
							class: "flex gap-2.5 rounded-md bg-error-tint p-3.5 text-sm text-error",
							role: "alert"
						}, [createVNode(_sfc_main$97, {
							name: "circle-alert",
							size: 20,
							class: "mt-0.5 shrink-0"
						}), createVNode("span", null, toDisplayString(unref(form).errors.email), 1)])) : createCommentVNode("", true),
						createVNode("form", {
							class: "space-y-5",
							onSubmit: withModifiers(submit, ["prevent"])
						}, [
							createVNode(_sfc_main$68, {
								modelValue: unref(form).email,
								"onUpdate:modelValue": ($event) => unref(form).email = $event,
								label: "E-mail",
								type: "email",
								placeholder: "marko@primjer.ba"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).password,
								"onUpdate:modelValue": ($event) => unref(form).password = $event,
								label: "Lozinka",
								type: "password",
								placeholder: "••••••••"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode("div", { class: "flex items-center justify-between" }, [createVNode(_sfc_main$66, {
								modelValue: unref(form).remember,
								"onUpdate:modelValue": ($event) => unref(form).remember = $event,
								label: "Zapamti me"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(unref(Link), {
								href: "/zaboravljena-lozinka",
								class: "text-sm font-medium text-primary hover:underline"
							}, {
								default: withCtx(() => [createTextVNode(" Zaboravljena lozinka? ")]),
								_: 1
							})]),
							createVNode(_sfc_main$93, {
								type: "submit",
								variant: "primary",
								block: "",
								disabled: unref(form).processing
							}, {
								default: withCtx(() => [createTextVNode(" Prijava ")]),
								_: 1
							}, 8, ["disabled"])
						], 32),
						createVNode("hr", { class: "border-border" }),
						createVNode("p", { class: "text-center text-sm text-text-muted" }, [createTextVNode(" Nemaš nalog? "), createVNode(unref(Link), {
							href: "/registracija",
							class: "font-semibold text-primary hover:underline"
						}, {
							default: withCtx(() => [createTextVNode(" Pridruži se ")]),
							_: 1
						})])
					])];
				}),
				_: 1
			}, _parent));
			_push(`</section>`);
		};
	}
};
var _sfc_setup$40 = _sfc_main$40.setup;
_sfc_main$40.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Login.vue");
	return _sfc_setup$40 ? _sfc_setup$40(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Map.vue
var Map_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$39 });
var _sfc_main$39 = {
	__name: "Map",
	__ssrInlineRender: true,
	props: { tacke: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		const props = __props;
		const aktivne = ref([]);
		const upit = ref("");
		const odabrana = ref(null);
		const filtrirano = computed(() => {
			let lista = props.tacke;
			if (aktivne.value.length) lista = lista.filter((t) => aktivne.value.includes(t.kategorija));
			if (upit.value.trim()) {
				const q = upit.value.trim().toLowerCase();
				lista = lista.filter((t) => t.naslov?.toLowerCase().includes(q) || t.lokacija?.toLowerCase().includes(q));
			}
			return lista;
		});
		function odaberi(item) {
			odabrana.value = item;
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "space-y-6 pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$95, { items: [{
							label: "Početna",
							to: "/"
						}, { label: "Mapa ponude" }] }, null, _parent, _scopeId));
						_push(`<header${_scopeId}><h1 class="text-2xl font-semibold text-heading md:text-3xl"${_scopeId}>Mapa ponude</h1><p class="mt-2 max-w-2xl text-text-muted"${_scopeId}> Istražite biznise, turističke lokalitete i događaje Teslića na interaktivnoj mapi. </p></header><div class="grid gap-6 lg:grid-cols-[320px_1fr]"${_scopeId}><div class="space-y-6"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$55, {
							modelValue: aktivne.value,
							"onUpdate:modelValue": ($event) => aktivne.value = $event,
							onSearch: (v) => upit.value = v
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$54, {
							items: filtrirano.value,
							onSelect: odaberi
						}, null, _parent, _scopeId));
						_push(`</div><div class="relative"${_scopeId}>`);
						_push(ssrRenderComponent(MapInteractive_default, {
							items: filtrirano.value,
							"active-categories": aktivne.value,
							height: "640px",
							onSelect: odaberi
						}, null, _parent, _scopeId));
						if (odabrana.value) {
							_push(`<div class="absolute right-4 top-4 z-[1000]"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$53, {
								item: odabrana.value,
								onClose: ($event) => odabrana.value = null
							}, null, _parent, _scopeId));
							_push(`</div>`);
						} else _push(`<!---->`);
						_push(`</div></div>`);
					} else return [
						createVNode(_sfc_main$95, { items: [{
							label: "Početna",
							to: "/"
						}, { label: "Mapa ponude" }] }),
						createVNode("header", null, [createVNode("h1", { class: "text-2xl font-semibold text-heading md:text-3xl" }, "Mapa ponude"), createVNode("p", { class: "mt-2 max-w-2xl text-text-muted" }, " Istražite biznise, turističke lokalitete i događaje Teslića na interaktivnoj mapi. ")]),
						createVNode("div", { class: "grid gap-6 lg:grid-cols-[320px_1fr]" }, [createVNode("div", { class: "space-y-6" }, [createVNode(_sfc_main$55, {
							modelValue: aktivne.value,
							"onUpdate:modelValue": ($event) => aktivne.value = $event,
							onSearch: (v) => upit.value = v
						}, null, 8, [
							"modelValue",
							"onUpdate:modelValue",
							"onSearch"
						]), createVNode(_sfc_main$54, {
							items: filtrirano.value,
							onSelect: odaberi
						}, null, 8, ["items"])]), createVNode("div", { class: "relative" }, [createVNode(MapInteractive_default, {
							items: filtrirano.value,
							"active-categories": aktivne.value,
							height: "640px",
							onSelect: odaberi
						}, null, 8, ["items", "active-categories"]), odabrana.value ? (openBlock(), createBlock("div", {
							key: 0,
							class: "absolute right-4 top-4 z-[1000]"
						}, [createVNode(_sfc_main$53, {
							item: odabrana.value,
							onClose: ($event) => odabrana.value = null
						}, null, 8, ["item", "onClose"])])) : createCommentVNode("", true)])])
					];
				}),
				_: 1
			}, _parent));
			_push(`</main>`);
		};
	}
};
var _sfc_setup$39 = _sfc_main$39.setup;
_sfc_main$39.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Map.vue");
	return _sfc_setup$39 ? _sfc_setup$39(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/NotFound.vue
var NotFound_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$38 });
var _sfc_main$38 = {
	__name: "NotFound",
	__ssrInlineRender: true,
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "py-20 text-center"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<p class="text-6xl font-bold text-primary"${_scopeId}>404</p><h1 class="mt-4 text-3xl font-bold text-heading"${_scopeId}>Stranica nije pronađena</h1><p class="mx-auto mt-3 max-w-md text-text-muted"${_scopeId}> Tražena stranica ne postoji ili je premještena. Vratite se na početnu i nastavite istraživati ponudu Teslića. </p><div class="mt-8 flex justify-center"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							to: "/",
							variant: "primary",
							icon: "arrow-right",
							"icon-position": "right"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Nazad na početnu `);
								else return [createTextVNode(" Nazad na početnu ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div>`);
					} else return [
						createVNode("p", { class: "text-6xl font-bold text-primary" }, "404"),
						createVNode("h1", { class: "mt-4 text-3xl font-bold text-heading" }, "Stranica nije pronađena"),
						createVNode("p", { class: "mx-auto mt-3 max-w-md text-text-muted" }, " Tražena stranica ne postoji ili je premještena. Vratite se na početnu i nastavite istraživati ponudu Teslića. "),
						createVNode("div", { class: "mt-8 flex justify-center" }, [createVNode(_sfc_main$93, {
							to: "/",
							variant: "primary",
							icon: "arrow-right",
							"icon-position": "right"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na početnu ")]),
							_: 1
						})])
					];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$38 = _sfc_main$38.setup;
_sfc_main$38.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/NotFound.vue");
	return _sfc_setup$38 ? _sfc_setup$38(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockHero.vue
var _sfc_main$37 = {
	__name: "BlockHero",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$96, mergeProps({
				variant: __props.data.variant || "split",
				kicker: __props.data.kicker || "",
				title: __props.data.title || "",
				subtitle: __props.data.subtitle || "",
				image: __props.data.image || ""
			}, _attrs), null, _parent));
		};
	}
};
var _sfc_setup$37 = _sfc_main$37.setup;
_sfc_main$37.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockHero.vue");
	return _sfc_setup$37 ? _sfc_setup$37(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockSectionHeader.vue
var _sfc_main$36 = {
	__name: "BlockSectionHeader",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "mt-12" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$47, {
						title: __props.data.title || "",
						"link-text": __props.data.linkText || "",
						to: __props.data.to || null
					}, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$47, {
						title: __props.data.title || "",
						"link-text": __props.data.linkText || "",
						to: __props.data.to || null
					}, null, 8, [
						"title",
						"link-text",
						"to"
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$36 = _sfc_main$36.setup;
_sfc_main$36.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockSectionHeader.vue");
	return _sfc_setup$36 ? _sfc_setup$36(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockRichText.vue
var _sfc_main$35 = {
	__name: "BlockRichText",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "mt-8" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(`<div class="prose prose-slate max-w-3xl text-text"${_scopeId}>${(__props.data.sadrzaj || "") ?? ""}</div>`);
					else return [createVNode("div", {
						class: "prose prose-slate max-w-3xl text-text",
						innerHTML: __props.data.sadrzaj || ""
					}, null, 8, ["innerHTML"])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$35 = _sfc_main$35.setup;
_sfc_main$35.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockRichText.vue");
	return _sfc_setup$35 ? _sfc_setup$35(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockCTA.vue
var _sfc_main$34 = {
	__name: "BlockCTA",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "my-14" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$94, {
						title: __props.data.title || "",
						text: __props.data.text || ""
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) {
								_push(`<!--[-->`);
								ssrRenderList(__props.data.buttons || [], (b, i) => {
									_push(ssrRenderComponent(_sfc_main$93, {
										key: i,
										to: b.url || "#",
										variant: b.variant || "sekundarna"
									}, {
										default: withCtx((_, _push, _parent, _scopeId) => {
											if (_push) _push(`${ssrInterpolate(b.label)}`);
											else return [createTextVNode(toDisplayString(b.label), 1)];
										}),
										_: 2
									}, _parent, _scopeId));
								});
								_push(`<!--]-->`);
							} else return [(openBlock(true), createBlock(Fragment, null, renderList(__props.data.buttons || [], (b, i) => {
								return openBlock(), createBlock(_sfc_main$93, {
									key: i,
									to: b.url || "#",
									variant: b.variant || "sekundarna"
								}, {
									default: withCtx(() => [createTextVNode(toDisplayString(b.label), 1)]),
									_: 2
								}, 1032, ["to", "variant"]);
							}), 128))];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$94, {
						title: __props.data.title || "",
						text: __props.data.text || ""
					}, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(__props.data.buttons || [], (b, i) => {
							return openBlock(), createBlock(_sfc_main$93, {
								key: i,
								to: b.url || "#",
								variant: b.variant || "sekundarna"
							}, {
								default: withCtx(() => [createTextVNode(toDisplayString(b.label), 1)]),
								_: 2
							}, 1032, ["to", "variant"]);
						}), 128))]),
						_: 1
					}, 8, ["title", "text"])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$34 = _sfc_main$34.setup;
_sfc_main$34.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockCTA.vue");
	return _sfc_setup$34 ? _sfc_setup$34(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockCardGrid.vue
var _sfc_main$33 = {
	__name: "BlockCardGrid",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		const props = __props;
		const cardByResource = {
			business: _sfc_main$70,
			location: _sfc_main$63,
			event: _sfc_main$62,
			ad: _sfc_main$84,
			story: _sfc_main$61
		};
		const card = computed(() => cardByResource[props.data.resource] || _sfc_main$70);
		const items = computed(() => props.data.items || []);
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "mt-12 space-y-6" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						if (__props.data.naslov) _push(ssrRenderComponent(_sfc_main$47, {
							title: __props.data.naslov,
							"link-text": __props.data.linkText || "",
							to: __props.data.to || null
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						if (items.value.length) _push(ssrRenderComponent(_sfc_main$90, { cols: __props.data.cols || 4 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(items.value, (item) => {
										ssrRenderVNode(_push, createVNode(resolveDynamicComponent(card.value), {
											key: item.slug,
											item
										}, null), _parent, _scopeId);
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(items.value, (item) => {
									return openBlock(), createBlock(resolveDynamicComponent(card.value), {
										key: item.slug,
										item
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						else _push(ssrRenderComponent(_sfc_main$85, {
							title: "Nema sadržaja",
							text: "Trenutno nema stavki za prikaz."
						}, null, _parent, _scopeId));
					} else return [__props.data.naslov ? (openBlock(), createBlock(_sfc_main$47, {
						key: 0,
						title: __props.data.naslov,
						"link-text": __props.data.linkText || "",
						to: __props.data.to || null
					}, null, 8, [
						"title",
						"link-text",
						"to"
					])) : createCommentVNode("", true), items.value.length ? (openBlock(), createBlock(_sfc_main$90, {
						key: 1,
						cols: __props.data.cols || 4
					}, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(items.value, (item) => {
							return openBlock(), createBlock(resolveDynamicComponent(card.value), {
								key: item.slug,
								item
							}, null, 8, ["item"]);
						}), 128))]),
						_: 1
					}, 8, ["cols"])) : (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Nema sadržaja",
						text: "Trenutno nema stavki za prikaz."
					}))];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$33 = _sfc_main$33.setup;
_sfc_main$33.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockCardGrid.vue");
	return _sfc_setup$33 ? _sfc_setup$33(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockCategoryNav.vue
var _sfc_main$32 = {
	__name: "BlockCategoryNav",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "mt-10" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6"${_scopeId}><!--[-->`);
						ssrRenderList(__props.data.items || [], (k) => {
							_push(ssrRenderComponent(unref(Link), {
								key: k.label,
								href: k.to || "#",
								class: "flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-3 py-5 text-center transition-shadow hover:shadow-[var(--shadow-md)]"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) {
										_push(`<span class="flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary"${_scopeId}>`);
										_push(ssrRenderComponent(_sfc_main$97, {
											name: k.icon || "tag",
											size: 22
										}, null, _parent, _scopeId));
										_push(`</span><span class="text-sm font-semibold leading-tight text-heading"${_scopeId}>${ssrInterpolate(k.label)}</span>`);
									} else return [createVNode("span", { class: "flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary" }, [createVNode(_sfc_main$97, {
										name: k.icon || "tag",
										size: 22
									}, null, 8, ["name"])]), createVNode("span", { class: "text-sm font-semibold leading-tight text-heading" }, toDisplayString(k.label), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
						});
						_push(`<!--]--></div>`);
					} else return [createVNode("div", { class: "grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6" }, [(openBlock(true), createBlock(Fragment, null, renderList(__props.data.items || [], (k) => {
						return openBlock(), createBlock(unref(Link), {
							key: k.label,
							href: k.to || "#",
							class: "flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-3 py-5 text-center transition-shadow hover:shadow-[var(--shadow-md)]"
						}, {
							default: withCtx(() => [createVNode("span", { class: "flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary" }, [createVNode(_sfc_main$97, {
								name: k.icon || "tag",
								size: 22
							}, null, 8, ["name"])]), createVNode("span", { class: "text-sm font-semibold leading-tight text-heading" }, toDisplayString(k.label), 1)]),
							_: 2
						}, 1032, ["href"]);
					}), 128))])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$32 = _sfc_main$32.setup;
_sfc_main$32.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockCategoryNav.vue");
	return _sfc_setup$32 ? _sfc_setup$32(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockGallery.vue
var _sfc_main$31 = {
	__name: "BlockGallery",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "mt-12 space-y-6" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						if (__props.data.naslov) _push(ssrRenderComponent(_sfc_main$47, { title: __props.data.naslov }, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(ssrRenderComponent(_sfc_main$73, {
							items: __props.data.items || [],
							variant: __props.data.variant || "grid"
						}, null, _parent, _scopeId));
					} else return [__props.data.naslov ? (openBlock(), createBlock(_sfc_main$47, {
						key: 0,
						title: __props.data.naslov
					}, null, 8, ["title"])) : createCommentVNode("", true), createVNode(_sfc_main$73, {
						items: __props.data.items || [],
						variant: __props.data.variant || "grid"
					}, null, 8, ["items", "variant"])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$31 = _sfc_main$31.setup;
_sfc_main$31.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockGallery.vue");
	return _sfc_setup$31 ? _sfc_setup$31(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockVideo.vue
var _sfc_main$30 = {
	__name: "BlockVideo",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "mt-12 space-y-6" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						if (__props.data.naslov) _push(ssrRenderComponent(_sfc_main$47, { title: __props.data.naslov }, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(ssrRenderComponent(_sfc_main$58, {
							src: __props.data.src || "",
							poster: __props.data.poster || ""
						}, null, _parent, _scopeId));
					} else return [__props.data.naslov ? (openBlock(), createBlock(_sfc_main$47, {
						key: 0,
						title: __props.data.naslov
					}, null, 8, ["title"])) : createCommentVNode("", true), createVNode(_sfc_main$58, {
						src: __props.data.src || "",
						poster: __props.data.poster || ""
					}, null, 8, ["src", "poster"])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$30 = _sfc_main$30.setup;
_sfc_main$30.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockVideo.vue");
	return _sfc_setup$30 ? _sfc_setup$30(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockMap.vue
var _sfc_main$29 = {
	__name: "BlockMap",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({ class: "mt-12 space-y-6" }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$47, {
							title: __props.data.naslov || "Mapa ponude",
							"link-text": __props.data.linkText || "Otvori mapu",
							to: __props.data.to || "/mapa"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(MapInteractive_default, {
							items: __props.data.items || [],
							height: __props.data.height || "480px"
						}, null, _parent, _scopeId));
					} else return [createVNode(_sfc_main$47, {
						title: __props.data.naslov || "Mapa ponude",
						"link-text": __props.data.linkText || "Otvori mapu",
						to: __props.data.to || "/mapa"
					}, null, 8, [
						"title",
						"link-text",
						"to"
					]), createVNode(MapInteractive_default, {
						items: __props.data.items || [],
						height: __props.data.height || "480px"
					}, null, 8, ["items", "height"])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$29 = _sfc_main$29.setup;
_sfc_main$29.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockMap.vue");
	return _sfc_setup$29 ? _sfc_setup$29(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/blocks/BlockSpacer.vue
var _sfc_main$28 = {
	__name: "BlockSpacer",
	__ssrInlineRender: true,
	props: { data: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		const props = __props;
		const heightClass = computed(() => {
			return {
				sm: "h-6",
				md: "h-12",
				lg: "h-20"
			}[props.data.size || "md"];
		});
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, _attrs, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="${ssrRenderClass([heightClass.value, "flex items-center"])}"${_scopeId}>`);
						if (__props.data.divider) _push(`<hr class="w-full border-border"${_scopeId}>`);
						else _push(`<!---->`);
						_push(`</div>`);
					} else return [createVNode("div", { class: [heightClass.value, "flex items-center"] }, [__props.data.divider ? (openBlock(), createBlock("hr", {
						key: 0,
						class: "w-full border-border"
					})) : createCommentVNode("", true)], 2)];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$28 = _sfc_main$28.setup;
_sfc_main$28.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/blocks/BlockSpacer.vue");
	return _sfc_setup$28 ? _sfc_setup$28(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/PageRenderer.vue
var PageRenderer_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$27 });
var _sfc_main$27 = {
	__name: "PageRenderer",
	__ssrInlineRender: true,
	props: {
		page: {
			type: Object,
			default: () => ({})
		},
		blocks: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const registry = {
			hero: _sfc_main$37,
			section_header: _sfc_main$36,
			rich_text: _sfc_main$35,
			cta: _sfc_main$34,
			card_grid: _sfc_main$33,
			category_nav: _sfc_main$32,
			gallery: _sfc_main$31,
			video: _sfc_main$30,
			map: _sfc_main$29,
			spacer: _sfc_main$28
		};
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(unref(Head), { title: __props.page.meta_title || __props.page.title }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (__props.page.meta_description) _push(`<meta name="description"${ssrRenderAttr("content", __props.page.meta_description)}${_scopeId}>`);
					else _push(`<!---->`);
					else return [__props.page.meta_description ? (openBlock(), createBlock("meta", {
						key: 0,
						name: "description",
						content: __props.page.meta_description
					}, null, 8, ["content"])) : createCommentVNode("", true)];
				}),
				_: 1
			}, _parent));
			_push(`<!--[-->`);
			ssrRenderList(__props.blocks, (block, i) => {
				_push(`<!--[-->`);
				if (registry[block.type] && (block.data?.visible ?? true)) ssrRenderVNode(_push, createVNode(resolveDynamicComponent(registry[block.type]), { data: block.data }, null), _parent);
				else _push(`<!---->`);
				_push(`<!--]-->`);
			});
			_push(`<!--]--></div>`);
		};
	}
};
var _sfc_setup$27 = _sfc_main$27.setup;
_sfc_main$27.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/PageRenderer.vue");
	return _sfc_setup$27 ? _sfc_setup$27(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/RegisterAuthor.vue
var RegisterAuthor_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$26 });
var _sfc_main$26 = {
	__name: "RegisterAuthor",
	__ssrInlineRender: true,
	setup(__props) {
		const form = useForm({
			role: "autor",
			name: "",
			email: "",
			telefon: "",
			password: "",
			password_confirmation: "",
			saglasnost: false
		});
		function submit() {
			form.post("/register");
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<section${ssrRenderAttrs(mergeProps({ class: "bg-surface-alt" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "py-12" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Pridruži se",
								to: "/pridruzi-se"
							},
							{ label: "Uključi se kao autor" }
						] }, null, _parent, _scopeId));
						_push(`<div class="mx-auto mt-6 w-full max-w-[560px] space-y-5 rounded-2xl border border-border bg-surface p-8"${_scopeId}><div${_scopeId}><h1 class="font-heading text-2xl font-bold text-heading"${_scopeId}>Uključi se kao autor</h1><p class="mt-2 text-sm text-text-muted"${_scopeId}> Nakon registracije nalog ide na pregled administratora. Priče kreiraš i šalješ na odobrenje nakon prijave. </p></div>`);
						if (Object.keys(unref(form).errors).length) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Neka polja nisu ispravno popunjena."
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<form class="space-y-5"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).name,
							"onUpdate:modelValue": ($event) => unref(form).name = $event,
							label: "Ime i prezime",
							error: unref(form).errors.name
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).email,
							"onUpdate:modelValue": ($event) => unref(form).email = $event,
							label: "E-mail",
							type: "email",
							error: unref(form).errors.email
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).telefon,
							"onUpdate:modelValue": ($event) => unref(form).telefon = $event,
							label: "Telefon",
							error: unref(form).errors.telefon
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).password,
							"onUpdate:modelValue": ($event) => unref(form).password = $event,
							label: "Lozinka",
							type: "password",
							error: unref(form).errors.password
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).password_confirmation,
							"onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
							label: "Potvrda lozinke",
							type: "password"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$66, {
							modelValue: unref(form).saglasnost,
							"onUpdate:modelValue": ($event) => unref(form).saglasnost = $event,
							label: "Saglasan/na sam s uslovima korištenja i obradom podataka."
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$93, {
							type: "submit",
							variant: "primary",
							block: "",
							disabled: unref(form).processing || !unref(form).saglasnost
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Registruj se `);
								else return [createTextVNode(" Registruj se ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</form><p class="text-center text-sm text-text-muted"${_scopeId}> Već imaš nalog? `);
						_push(ssrRenderComponent(unref(Link), {
							href: "/prijava",
							class: "font-semibold text-primary hover:underline"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Prijavi se`);
								else return [createTextVNode("Prijavi se")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</p></div>`);
					} else return [createVNode(_sfc_main$95, { items: [
						{
							label: "Početna",
							to: "/"
						},
						{
							label: "Pridruži se",
							to: "/pridruzi-se"
						},
						{ label: "Uključi se kao autor" }
					] }), createVNode("div", { class: "mx-auto mt-6 w-full max-w-[560px] space-y-5 rounded-2xl border border-border bg-surface p-8" }, [
						createVNode("div", null, [createVNode("h1", { class: "font-heading text-2xl font-bold text-heading" }, "Uključi se kao autor"), createVNode("p", { class: "mt-2 text-sm text-text-muted" }, " Nakon registracije nalog ide na pregled administratora. Priče kreiraš i šalješ na odobrenje nakon prijave. ")]),
						Object.keys(unref(form).errors).length ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Neka polja nisu ispravno popunjena."
						})) : createCommentVNode("", true),
						createVNode("form", {
							class: "space-y-5",
							onSubmit: withModifiers(submit, ["prevent"])
						}, [
							createVNode(_sfc_main$68, {
								modelValue: unref(form).name,
								"onUpdate:modelValue": ($event) => unref(form).name = $event,
								label: "Ime i prezime",
								error: unref(form).errors.name
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).email,
								"onUpdate:modelValue": ($event) => unref(form).email = $event,
								label: "E-mail",
								type: "email",
								error: unref(form).errors.email
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).telefon,
								"onUpdate:modelValue": ($event) => unref(form).telefon = $event,
								label: "Telefon",
								error: unref(form).errors.telefon
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).password,
								"onUpdate:modelValue": ($event) => unref(form).password = $event,
								label: "Lozinka",
								type: "password",
								error: unref(form).errors.password
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).password_confirmation,
								"onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
								label: "Potvrda lozinke",
								type: "password"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$66, {
								modelValue: unref(form).saglasnost,
								"onUpdate:modelValue": ($event) => unref(form).saglasnost = $event,
								label: "Saglasan/na sam s uslovima korištenja i obradom podataka."
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$93, {
								type: "submit",
								variant: "primary",
								block: "",
								disabled: unref(form).processing || !unref(form).saglasnost
							}, {
								default: withCtx(() => [createTextVNode(" Registruj se ")]),
								_: 1
							}, 8, ["disabled"])
						], 32),
						createVNode("p", { class: "text-center text-sm text-text-muted" }, [createTextVNode(" Već imaš nalog? "), createVNode(unref(Link), {
							href: "/prijava",
							class: "font-semibold text-primary hover:underline"
						}, {
							default: withCtx(() => [createTextVNode("Prijavi se")]),
							_: 1
						})])
					])];
				}),
				_: 1
			}, _parent));
			_push(`</section>`);
		};
	}
};
var _sfc_setup$26 = _sfc_main$26.setup;
_sfc_main$26.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/RegisterAuthor.vue");
	return _sfc_setup$26 ? _sfc_setup$26(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/RegisterBusiness.vue
var RegisterBusiness_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$25 });
var _sfc_main$25 = {
	__name: "RegisterBusiness",
	__ssrInlineRender: true,
	setup(__props) {
		const form = useForm({
			role: "biznis",
			name: "",
			email: "",
			telefon: "",
			password: "",
			password_confirmation: "",
			saglasnost: false
		});
		function submit() {
			form.post("/register");
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<section${ssrRenderAttrs(mergeProps({ class: "bg-surface-alt" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "py-12" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Pridruži se",
								to: "/pridruzi-se"
							},
							{ label: "Registruj biznis" }
						] }, null, _parent, _scopeId));
						_push(`<div class="mx-auto mt-6 w-full max-w-[560px] space-y-5 rounded-2xl border border-border bg-surface p-8"${_scopeId}><div${_scopeId}><h1 class="font-heading text-2xl font-bold text-heading"${_scopeId}>Registruj biznis</h1><p class="mt-2 text-sm text-text-muted"${_scopeId}> Nakon registracije nalog ide na pregled administratora. Profil i objave uređuješ nakon odobrenja. </p></div>`);
						if (Object.keys(unref(form).errors).length) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Neka polja nisu ispravno popunjena."
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<form class="space-y-5"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).name,
							"onUpdate:modelValue": ($event) => unref(form).name = $event,
							label: "Naziv biznisa",
							error: unref(form).errors.name
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).email,
							"onUpdate:modelValue": ($event) => unref(form).email = $event,
							label: "E-mail",
							type: "email",
							error: unref(form).errors.email
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).telefon,
							"onUpdate:modelValue": ($event) => unref(form).telefon = $event,
							label: "Telefon",
							error: unref(form).errors.telefon
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).password,
							"onUpdate:modelValue": ($event) => unref(form).password = $event,
							label: "Lozinka",
							type: "password",
							error: unref(form).errors.password
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).password_confirmation,
							"onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
							label: "Potvrda lozinke",
							type: "password"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$66, {
							modelValue: unref(form).saglasnost,
							"onUpdate:modelValue": ($event) => unref(form).saglasnost = $event,
							label: "Saglasan/na sam s uslovima korištenja i obradom podataka."
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$93, {
							type: "submit",
							variant: "primary",
							block: "",
							disabled: unref(form).processing || !unref(form).saglasnost
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Registruj se `);
								else return [createTextVNode(" Registruj se ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</form><p class="text-center text-sm text-text-muted"${_scopeId}> Već imaš nalog? `);
						_push(ssrRenderComponent(unref(Link), {
							href: "/prijava",
							class: "font-semibold text-primary hover:underline"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Prijavi se`);
								else return [createTextVNode("Prijavi se")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</p></div>`);
					} else return [createVNode(_sfc_main$95, { items: [
						{
							label: "Početna",
							to: "/"
						},
						{
							label: "Pridruži se",
							to: "/pridruzi-se"
						},
						{ label: "Registruj biznis" }
					] }), createVNode("div", { class: "mx-auto mt-6 w-full max-w-[560px] space-y-5 rounded-2xl border border-border bg-surface p-8" }, [
						createVNode("div", null, [createVNode("h1", { class: "font-heading text-2xl font-bold text-heading" }, "Registruj biznis"), createVNode("p", { class: "mt-2 text-sm text-text-muted" }, " Nakon registracije nalog ide na pregled administratora. Profil i objave uređuješ nakon odobrenja. ")]),
						Object.keys(unref(form).errors).length ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Neka polja nisu ispravno popunjena."
						})) : createCommentVNode("", true),
						createVNode("form", {
							class: "space-y-5",
							onSubmit: withModifiers(submit, ["prevent"])
						}, [
							createVNode(_sfc_main$68, {
								modelValue: unref(form).name,
								"onUpdate:modelValue": ($event) => unref(form).name = $event,
								label: "Naziv biznisa",
								error: unref(form).errors.name
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).email,
								"onUpdate:modelValue": ($event) => unref(form).email = $event,
								label: "E-mail",
								type: "email",
								error: unref(form).errors.email
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).telefon,
								"onUpdate:modelValue": ($event) => unref(form).telefon = $event,
								label: "Telefon",
								error: unref(form).errors.telefon
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).password,
								"onUpdate:modelValue": ($event) => unref(form).password = $event,
								label: "Lozinka",
								type: "password",
								error: unref(form).errors.password
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).password_confirmation,
								"onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
								label: "Potvrda lozinke",
								type: "password"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$66, {
								modelValue: unref(form).saglasnost,
								"onUpdate:modelValue": ($event) => unref(form).saglasnost = $event,
								label: "Saglasan/na sam s uslovima korištenja i obradom podataka."
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$93, {
								type: "submit",
								variant: "primary",
								block: "",
								disabled: unref(form).processing || !unref(form).saglasnost
							}, {
								default: withCtx(() => [createTextVNode(" Registruj se ")]),
								_: 1
							}, 8, ["disabled"])
						], 32),
						createVNode("p", { class: "text-center text-sm text-text-muted" }, [createTextVNode(" Već imaš nalog? "), createVNode(unref(Link), {
							href: "/prijava",
							class: "font-semibold text-primary hover:underline"
						}, {
							default: withCtx(() => [createTextVNode("Prijavi se")]),
							_: 1
						})])
					])];
				}),
				_: 1
			}, _parent));
			_push(`</section>`);
		};
	}
};
var _sfc_setup$25 = _sfc_main$25.setup;
_sfc_main$25.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/RegisterBusiness.vue");
	return _sfc_setup$25 ? _sfc_setup$25(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/RegisterChoice.vue
var RegisterChoice_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$24 });
var _sfc_main$24 = {
	__name: "RegisterChoice",
	__ssrInlineRender: true,
	setup(__props) {
		const opcije = [{
			icon: "store",
			naslov: "Registruj biznis",
			opis: "Predstavite svoju ponudu, proizvode ili usluge posjetiocima Teslića.",
			cta: "Registruj biznis",
			to: "/pridruzi-se/biznis"
		}, {
			icon: "pen-tool",
			naslov: "Postani autor",
			opis: "Pišite priče i objavljujte sadržaj o turizmu i životu u Tesliću.",
			cta: "Postani autor",
			to: "/pridruzi-se/autor"
		}];
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<section${ssrRenderAttrs(mergeProps({ class: "bg-surface-alt" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "flex min-h-[600px] flex-col items-center justify-center gap-8 py-16" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="max-w-[680px] space-y-2.5 text-center"${_scopeId}><h1 class="font-heading text-3xl font-bold text-heading md:text-[32px]"${_scopeId}>Napravi nalog</h1><p class="text-base text-text-muted"${_scopeId}>Odaberite tip naloga koji želite kreirati na platformi.</p></div><div class="flex flex-col gap-6 sm:flex-row"${_scopeId}><!--[-->`);
						ssrRenderList(opcije, (o) => {
							_push(`<div class="flex w-full flex-col gap-4 rounded-2xl border border-border bg-surface p-7 sm:w-80"${_scopeId}><span class="flex size-14 items-center justify-center rounded-md bg-primary-tint text-primary"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: o.icon,
								size: 26
							}, null, _parent, _scopeId));
							_push(`</span><h2 class="font-heading text-xl font-bold text-heading"${_scopeId}>${ssrInterpolate(o.naslov)}</h2><p class="text-sm leading-relaxed text-text-muted"${_scopeId}>${ssrInterpolate(o.opis)}</p>`);
							_push(ssrRenderComponent(_sfc_main$93, {
								to: o.to,
								variant: "primary",
								block: ""
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(o.cta)}`);
									else return [createTextVNode(toDisplayString(o.cta), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
							_push(`</div>`);
						});
						_push(`<!--]--></div><div class="flex items-center gap-2 rounded-md bg-info-tint px-4 py-3"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "info",
							size: 18,
							class: "text-info"
						}, null, _parent, _scopeId));
						_push(`<span class="text-sm text-text"${_scopeId}>Nakon prijave, nalog ide na pregled administratora.</span></div>`);
					} else return [
						createVNode("div", { class: "max-w-[680px] space-y-2.5 text-center" }, [createVNode("h1", { class: "font-heading text-3xl font-bold text-heading md:text-[32px]" }, "Napravi nalog"), createVNode("p", { class: "text-base text-text-muted" }, "Odaberite tip naloga koji želite kreirati na platformi.")]),
						createVNode("div", { class: "flex flex-col gap-6 sm:flex-row" }, [(openBlock(), createBlock(Fragment, null, renderList(opcije, (o) => {
							return createVNode("div", {
								key: o.naslov,
								class: "flex w-full flex-col gap-4 rounded-2xl border border-border bg-surface p-7 sm:w-80"
							}, [
								createVNode("span", { class: "flex size-14 items-center justify-center rounded-md bg-primary-tint text-primary" }, [createVNode(_sfc_main$97, {
									name: o.icon,
									size: 26
								}, null, 8, ["name"])]),
								createVNode("h2", { class: "font-heading text-xl font-bold text-heading" }, toDisplayString(o.naslov), 1),
								createVNode("p", { class: "text-sm leading-relaxed text-text-muted" }, toDisplayString(o.opis), 1),
								createVNode(_sfc_main$93, {
									to: o.to,
									variant: "primary",
									block: ""
								}, {
									default: withCtx(() => [createTextVNode(toDisplayString(o.cta), 1)]),
									_: 2
								}, 1032, ["to"])
							]);
						}), 64))]),
						createVNode("div", { class: "flex items-center gap-2 rounded-md bg-info-tint px-4 py-3" }, [createVNode(_sfc_main$97, {
							name: "info",
							size: 18,
							class: "text-info"
						}), createVNode("span", { class: "text-sm text-text" }, "Nakon prijave, nalog ide na pregled administratora.")])
					];
				}),
				_: 1
			}, _parent));
			_push(`</section>`);
		};
	}
};
var _sfc_setup$24 = _sfc_main$24.setup;
_sfc_main$24.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/RegisterChoice.vue");
	return _sfc_setup$24 ? _sfc_setup$24(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/StoriesListing.vue
var StoriesListing_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$23 });
var PO_STRANICI$1 = 9;
var _sfc_main$23 = {
	__name: "StoriesListing",
	__ssrInlineRender: true,
	props: { price: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		const props = __props;
		const data = computed(() => props.price);
		const upit = ref("");
		const kategorija = ref("");
		const autor = ref("");
		const stranica = ref(1);
		const kategorijeOpcije = [
			{
				value: "Domaćini pričaju",
				label: "Domaćini pričaju"
			},
			{
				value: "Ljudi i biznisi",
				label: "Ljudi i biznisi"
			},
			{
				value: "Naša svakodnevica",
				label: "Naša svakodnevica"
			}
		];
		const autoriOpcije = computed(() => {
			const set = /* @__PURE__ */ new Set();
			for (const p of data.value || []) if (p.autor) set.add(p.autor);
			return [...set].map((a) => ({
				value: a,
				label: a
			}));
		});
		const istaknuta = computed(() => (data.value || []).find((p) => p.featured) || null);
		const obicne = computed(() => (data.value || []).filter((p) => !p.featured));
		const filtrirano = computed(() => {
			let lista = obicne.value;
			if (kategorija.value) lista = lista.filter((p) => p.kategorija?.label === kategorija.value);
			if (autor.value) lista = lista.filter((p) => p.autor === autor.value);
			if (upit.value.trim()) {
				const q = upit.value.trim().toLowerCase();
				lista = lista.filter((p) => p.naslov?.toLowerCase().includes(q) || p.izvod?.toLowerCase().includes(q));
			}
			return lista;
		});
		const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI$1)));
		const vidljivi = computed(() => filtrirano.value.slice((stranica.value - 1) * PO_STRANICI$1, stranica.value * PO_STRANICI$1));
		const imaFiltera = computed(() => kategorija.value || autor.value || upit.value.trim());
		const aktivniChipovi = computed(() => {
			const chips = [];
			if (kategorija.value) chips.push({
				key: "kategorija",
				label: kategorija.value
			});
			if (autor.value) chips.push({
				key: "autor",
				label: autor.value
			});
			if (upit.value.trim()) chips.push({
				key: "upit",
				label: `„${upit.value.trim()}”`
			});
			return chips;
		});
		watch([
			kategorija,
			autor,
			upit
		], () => {
			stranica.value = 1;
		});
		function ocisti() {
			kategorija.value = "";
			autor.value = "";
			upit.value = "";
		}
		function ukloni(key) {
			if (key === "kategorija") kategorija.value = "";
			if (key === "autor") autor.value = "";
			if (key === "upit") upit.value = "";
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Priče iz Teslića" }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Priče iz Teslića" }] })];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(`<h1 class="font-heading text-3xl font-bold text-heading md:text-4xl"${_scopeId}>Priče iz Teslića</h1><p class="mt-2 max-w-2xl text-text-muted"${_scopeId}> Domaćini, zanatlije i autori pričaju o ljudima, biznisima i svakodnevici kraja. </p>`);
					else return [createVNode("h1", { class: "font-heading text-3xl font-bold text-heading md:text-4xl" }, "Priče iz Teslića"), createVNode("p", { class: "mt-2 max-w-2xl text-text-muted" }, " Domaćini, zanatlije i autori pričaju o ljudima, biznisima i svakodnevici kraja. ")];
				}),
				_: 1
			}, _parent));
			if (istaknuta.value && !imaFiltera.value) _push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$60, { item: istaknuta.value }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$60, { item: istaknuta.value }, null, 8, ["item"])];
				}),
				_: 1
			}, _parent));
			else _push(`<!---->`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) {
								_push(ssrRenderComponent(_sfc_main$78, {
									modelValue: kategorija.value,
									"onUpdate:modelValue": ($event) => kategorija.value = $event,
									options: kategorijeOpcije,
									placeholder: "Sve kategorije"
								}, null, _parent, _scopeId));
								_push(ssrRenderComponent(_sfc_main$78, {
									modelValue: autor.value,
									"onUpdate:modelValue": ($event) => autor.value = $event,
									options: autoriOpcije.value,
									placeholder: "Svi autori"
								}, null, _parent, _scopeId));
								_push(ssrRenderComponent(_sfc_main$79, {
									modelValue: upit.value,
									"onUpdate:modelValue": ($event) => upit.value = $event,
									placeholder: "Pretraži priče…"
								}, null, _parent, _scopeId));
							} else return [
								createVNode(_sfc_main$78, {
									modelValue: kategorija.value,
									"onUpdate:modelValue": ($event) => kategorija.value = $event,
									options: kategorijeOpcije,
									placeholder: "Sve kategorije"
								}, null, 8, ["modelValue", "onUpdate:modelValue"]),
								createVNode(_sfc_main$78, {
									modelValue: autor.value,
									"onUpdate:modelValue": ($event) => autor.value = $event,
									options: autoriOpcije.value,
									placeholder: "Svi autori"
								}, null, 8, [
									"modelValue",
									"onUpdate:modelValue",
									"options"
								]),
								createVNode(_sfc_main$79, {
									modelValue: upit.value,
									"onUpdate:modelValue": ($event) => upit.value = $event,
									placeholder: "Pretraži priče…"
								}, null, 8, ["modelValue", "onUpdate:modelValue"])
							];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx(() => [
							createVNode(_sfc_main$78, {
								modelValue: kategorija.value,
								"onUpdate:modelValue": ($event) => kategorija.value = $event,
								options: kategorijeOpcije,
								placeholder: "Sve kategorije"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$78, {
								modelValue: autor.value,
								"onUpdate:modelValue": ($event) => autor.value = $event,
								options: autoriOpcije.value,
								placeholder: "Svi autori"
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"options"
							]),
							createVNode(_sfc_main$79, {
								modelValue: upit.value,
								"onUpdate:modelValue": ($event) => upit.value = $event,
								placeholder: "Pretraži priče…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])
						]),
						_: 1
					}, 8, ["chips"])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!vidljivi.value.length) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Nema priča",
						text: "Za odabrane filtere nema priča. Pokušajte promijeniti kategoriju, autora ili pretragu."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ocisti
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`Očisti filtere`);
									else return [createTextVNode("Očisti filtere")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ocisti
							}, {
								default: withCtx(() => [createTextVNode("Očisti filtere")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(vidljivi.value, (p) => {
										_push(ssrRenderComponent(_sfc_main$61, {
											key: p.slug,
											item: p
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (p) => {
									return openBlock(), createBlock(_sfc_main$61, {
										key: p.slug,
										item: p
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						if (ukupnoStranica.value > 1) {
							_push(`<div class="mt-10 flex justify-center"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$77, {
								modelValue: stranica.value,
								"onUpdate:modelValue": ($event) => stranica.value = $event,
								total: ukupnoStranica.value
							}, null, _parent, _scopeId));
							_push(`</div>`);
						} else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!vidljivi.value.length ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Nema priča",
						text: "Za odabrane filtere nema priča. Pokušajte promijeniti kategoriju, autora ili pretragu."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							size: "sm",
							onClick: ocisti
						}, {
							default: withCtx(() => [createTextVNode("Očisti filtere")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [createVNode(_sfc_main$90, { cols: 3 }, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (p) => {
							return openBlock(), createBlock(_sfc_main$61, {
								key: p.slug,
								item: p
							}, null, 8, ["item"]);
						}), 128))]),
						_: 1
					}), ukupnoStranica.value > 1 ? (openBlock(), createBlock("div", {
						key: 0,
						class: "mt-10 flex justify-center"
					}, [createVNode(_sfc_main$77, {
						modelValue: stranica.value,
						"onUpdate:modelValue": ($event) => stranica.value = $event,
						total: ukupnoStranica.value
					}, null, 8, [
						"modelValue",
						"onUpdate:modelValue",
						"total"
					])])) : createCommentVNode("", true)], 64))];
				}),
				_: 1
			}, _parent));
			_push(`</main>`);
		};
	}
};
var _sfc_setup$23 = _sfc_main$23.setup;
_sfc_main$23.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/StoriesListing.vue");
	return _sfc_setup$23 ? _sfc_setup$23(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/StoryDetail.vue
var StoryDetail_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$22 });
var _sfc_main$22 = {
	__name: "StoryDetail",
	__ssrInlineRender: true,
	props: {
		slug: {
			type: String,
			default: ""
		},
		prica: {
			type: Object,
			default: null
		},
		slicne: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const prica = computed(() => props.prica);
		const slicne = computed(() => props.slicne);
		const autor = computed(() => ({
			ime: prica.value?.autor,
			bio: prica.value?.autorBio
		}));
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$98, mergeProps({
				as: "main",
				class: "py-8"
			}, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!prica.value) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Priča nije pronađena",
						text: "Tražena priča ne postoji ili je uklonjena."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/price"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Nazad na priče `);
									else return [createTextVNode(" Nazad na priče ")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								icon: "arrow-left",
								to: "/price"
							}, {
								default: withCtx(() => [createTextVNode(" Nazad na priče ")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Priče iz Teslića",
								to: "/price"
							},
							{ label: prica.value.naslov }
						] }, null, _parent, _scopeId));
						_push(`<div class="mt-6 overflow-hidden rounded-lg"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: prica.value.kategorija?.label,
							title: prica.value.naslov,
							subtitle: `${prica.value.autor} · ${prica.value.datum}`,
							image: prica.value.slika
						}, null, _parent, _scopeId));
						_push(`</div><article class="mx-auto mt-10 max-w-2xl"${_scopeId}>`);
						if (prica.value.izvod) _push(`<p class="mb-6 font-heading text-xl font-medium leading-relaxed text-heading"${_scopeId}>${ssrInterpolate(prica.value.izvod)}</p>`);
						else _push(`<!---->`);
						_push(`<div class="space-y-4 whitespace-pre-line text-lg leading-relaxed text-text"${_scopeId}>${ssrInterpolate(prica.value.sadrzaj)}</div></article>`);
						if (prica.value.galerija?.length) {
							_push(`<section class="mx-auto mt-10 max-w-2xl"${_scopeId}><h2 class="mb-4 font-heading text-2xl font-bold text-heading"${_scopeId}>Galerija</h2>`);
							_push(ssrRenderComponent(_sfc_main$73, { items: prica.value.galerija }, null, _parent, _scopeId));
							_push(`</section>`);
						} else _push(`<!---->`);
						_push(`<div class="mx-auto mt-10 max-w-2xl"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$57, {
							author: autor.value,
							to: "/price"
						}, null, _parent, _scopeId));
						_push(`</div>`);
						if (slicne.value.length) _push(ssrRenderComponent(_sfc_main$89, { title: "Druge priče" }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(slicne.value, (p) => {
										_push(ssrRenderComponent(_sfc_main$61, {
											key: p.slug,
											item: p
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(slicne.value, (p) => {
									return openBlock(), createBlock(_sfc_main$61, {
										key: p.slug,
										item: p
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!prica.value ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Priča nije pronađena",
						text: "Tražena priča ne postoji ili je uklonjena."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "arrow-left",
							to: "/price"
						}, {
							default: withCtx(() => [createTextVNode(" Nazad na priče ")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [
						createVNode(_sfc_main$95, { items: [
							{
								label: "Početna",
								to: "/"
							},
							{
								label: "Priče iz Teslića",
								to: "/price"
							},
							{ label: prica.value.naslov }
						] }, null, 8, ["items"]),
						createVNode("div", { class: "mt-6 overflow-hidden rounded-lg" }, [createVNode(_sfc_main$96, {
							variant: "slika-pozadina",
							kicker: prica.value.kategorija?.label,
							title: prica.value.naslov,
							subtitle: `${prica.value.autor} · ${prica.value.datum}`,
							image: prica.value.slika
						}, null, 8, [
							"kicker",
							"title",
							"subtitle",
							"image"
						])]),
						createVNode("article", { class: "mx-auto mt-10 max-w-2xl" }, [prica.value.izvod ? (openBlock(), createBlock("p", {
							key: 0,
							class: "mb-6 font-heading text-xl font-medium leading-relaxed text-heading"
						}, toDisplayString(prica.value.izvod), 1)) : createCommentVNode("", true), createVNode("div", { class: "space-y-4 whitespace-pre-line text-lg leading-relaxed text-text" }, toDisplayString(prica.value.sadrzaj), 1)]),
						prica.value.galerija?.length ? (openBlock(), createBlock("section", {
							key: 0,
							class: "mx-auto mt-10 max-w-2xl"
						}, [createVNode("h2", { class: "mb-4 font-heading text-2xl font-bold text-heading" }, "Galerija"), createVNode(_sfc_main$73, { items: prica.value.galerija }, null, 8, ["items"])])) : createCommentVNode("", true),
						createVNode("div", { class: "mx-auto mt-10 max-w-2xl" }, [createVNode(_sfc_main$57, {
							author: autor.value,
							to: "/price"
						}, null, 8, ["author"])]),
						slicne.value.length ? (openBlock(), createBlock(_sfc_main$89, {
							key: 1,
							title: "Druge priče"
						}, {
							default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(slicne.value, (p) => {
								return openBlock(), createBlock(_sfc_main$61, {
									key: p.slug,
									item: p
								}, null, 8, ["item"]);
							}), 128))]),
							_: 1
						})) : createCommentVNode("", true)
					], 64))];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$22 = _sfc_main$22.setup;
_sfc_main$22.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/StoryDetail.vue");
	return _sfc_setup$22 ? _sfc_setup$22(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/TourismListing.vue
var TourismListing_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$21 });
var PO_STRANICI = 8;
var _sfc_main$21 = {
	__name: "TourismListing",
	__ssrInlineRender: true,
	props: { lokaliteti: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		const props = __props;
		const data = computed(() => props.lokaliteti);
		const upit = ref("");
		const kategorija = ref("");
		const stranica = ref(1);
		const kategorijeOpcije = [
			{
				value: "priroda",
				label: "Prirodne atrakcije"
			},
			{
				value: "kultura",
				label: "Kulturne manifestacije"
			},
			{
				value: "smjestaj",
				label: "Gdje odsjesti"
			}
		];
		const filtrirano = computed(() => {
			let lista = data.value || [];
			if (kategorija.value) lista = lista.filter((l) => l.kategorija?.icon === kategorija.value);
			if (upit.value.trim()) {
				const q = upit.value.trim().toLowerCase();
				lista = lista.filter((l) => l.naslov?.toLowerCase().includes(q) || l.opis?.toLowerCase().includes(q) || l.lokacija?.toLowerCase().includes(q));
			}
			return lista;
		});
		const ukupnoStranica = computed(() => Math.max(1, Math.ceil(filtrirano.value.length / PO_STRANICI)));
		const vidljivi = computed(() => filtrirano.value.slice((stranica.value - 1) * PO_STRANICI, stranica.value * PO_STRANICI));
		const preporuceni = computed(() => (data.value || []).filter((l) => l.preporuceno).slice(0, 3));
		const aktivniChipovi = computed(() => {
			const chips = [];
			if (kategorija.value) {
				const k = kategorijeOpcije.find((o) => o.value === kategorija.value);
				chips.push({
					key: "kategorija",
					label: k ? k.label : kategorija.value
				});
			}
			if (upit.value.trim()) chips.push({
				key: "upit",
				label: `„${upit.value.trim()}”`
			});
			return chips;
		});
		watch([kategorija, upit], () => {
			stranica.value = 1;
		});
		function ocisti() {
			kategorija.value = "";
			upit.value = "";
		}
		function ukloni(key) {
			if (key === "kategorija") kategorija.value = "";
			if (key === "upit") upit.value = "";
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<main${ssrRenderAttrs(mergeProps({ class: "pb-12 md:pb-16" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$96, {
				variant: "slika-pozadina",
				kicker: "Turizam u Tesliću",
				title: "Priroda, kultura i mjesta za odmor",
				subtitle: "Planina Borja, Banja Vrućica, vrh Očauš i druge atrakcije kraja na jednom mjestu."
			}, null, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "pt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Turizam u Tesliću" }] }, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$95, { items: [{
						label: "Početna",
						to: "/"
					}, { label: "Turizam u Tesliću" }] })];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-6" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) {
								_push(ssrRenderComponent(_sfc_main$78, {
									modelValue: kategorija.value,
									"onUpdate:modelValue": ($event) => kategorija.value = $event,
									options: kategorijeOpcije,
									placeholder: "Sve kategorije"
								}, null, _parent, _scopeId));
								_push(ssrRenderComponent(_sfc_main$79, {
									modelValue: upit.value,
									"onUpdate:modelValue": ($event) => upit.value = $event,
									placeholder: "Pretraži atrakcije…"
								}, null, _parent, _scopeId));
							} else return [createVNode(_sfc_main$78, {
								modelValue: kategorija.value,
								"onUpdate:modelValue": ($event) => kategorija.value = $event,
								options: kategorijeOpcije,
								placeholder: "Sve kategorije"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
								modelValue: upit.value,
								"onUpdate:modelValue": ($event) => upit.value = $event,
								placeholder: "Pretraži atrakcije…"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])];
						}),
						_: 1
					}, _parent, _scopeId));
					else return [createVNode(_sfc_main$80, {
						chips: aktivniChipovi.value,
						onClear: ocisti,
						onRemove: ukloni
					}, {
						default: withCtx(() => [createVNode(_sfc_main$78, {
							modelValue: kategorija.value,
							"onUpdate:modelValue": ($event) => kategorija.value = $event,
							options: kategorijeOpcije,
							placeholder: "Sve kategorije"
						}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$79, {
							modelValue: upit.value,
							"onUpdate:modelValue": ($event) => upit.value = $event,
							placeholder: "Pretraži atrakcije…"
						}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
						_: 1
					}, 8, ["chips"])];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-8" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) if (!vidljivi.value.length) _push(ssrRenderComponent(_sfc_main$85, {
						title: "Nema rezultata",
						text: "Za odabrane filtere nema atrakcija. Pokušajte promijeniti kategoriju ili pretragu."
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(ssrRenderComponent(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ocisti
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`Očisti filtere`);
									else return [createTextVNode("Očisti filtere")];
								}),
								_: 1
							}, _parent, _scopeId));
							else return [createVNode(_sfc_main$93, {
								variant: "secondary",
								size: "sm",
								onClick: ocisti
							}, {
								default: withCtx(() => [createTextVNode("Očisti filtere")]),
								_: 1
							})];
						}),
						_: 1
					}, _parent, _scopeId));
					else {
						_push(`<!--[-->`);
						_push(ssrRenderComponent(_sfc_main$90, null, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(vidljivi.value, (l) => {
										_push(ssrRenderComponent(_sfc_main$63, {
											key: l.slug,
											item: l
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (l) => {
									return openBlock(), createBlock(_sfc_main$63, {
										key: l.slug,
										item: l
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
						if (ukupnoStranica.value > 1) {
							_push(`<div class="mt-10 flex justify-center"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$77, {
								modelValue: stranica.value,
								"onUpdate:modelValue": ($event) => stranica.value = $event,
								total: ukupnoStranica.value
							}, null, _parent, _scopeId));
							_push(`</div>`);
						} else _push(`<!---->`);
						_push(`<!--]-->`);
					}
					else return [!vidljivi.value.length ? (openBlock(), createBlock(_sfc_main$85, {
						key: 2,
						title: "Nema rezultata",
						text: "Za odabrane filtere nema atrakcija. Pokušajte promijeniti kategoriju ili pretragu."
					}, {
						default: withCtx(() => [createVNode(_sfc_main$93, {
							variant: "secondary",
							size: "sm",
							onClick: ocisti
						}, {
							default: withCtx(() => [createTextVNode("Očisti filtere")]),
							_: 1
						})]),
						_: 1
					})) : (openBlock(), createBlock(Fragment, { key: 3 }, [createVNode(_sfc_main$90, null, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(vidljivi.value, (l) => {
							return openBlock(), createBlock(_sfc_main$63, {
								key: l.slug,
								item: l
							}, null, 8, ["item"]);
						}), 128))]),
						_: 1
					}), ukupnoStranica.value > 1 ? (openBlock(), createBlock("div", {
						key: 0,
						class: "mt-10 flex justify-center"
					}, [createVNode(_sfc_main$77, {
						modelValue: stranica.value,
						"onUpdate:modelValue": ($event) => stranica.value = $event,
						total: ukupnoStranica.value
					}, null, 8, [
						"modelValue",
						"onUpdate:modelValue",
						"total"
					])])) : createCommentVNode("", true)], 64))];
				}),
				_: 1
			}, _parent));
			_push(ssrRenderComponent(_sfc_main$98, { class: "mt-12" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<h2 class="mb-6 font-heading text-2xl font-bold text-heading"${_scopeId}>Ponuda na mapi</h2><div class="max-w-md"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$72, {
							label: "Teslić i okolina",
							to: "/mapa"
						}, null, _parent, _scopeId));
						_push(`</div>`);
					} else return [createVNode("h2", { class: "mb-6 font-heading text-2xl font-bold text-heading" }, "Ponuda na mapi"), createVNode("div", { class: "max-w-md" }, [createVNode(_sfc_main$72, {
						label: "Teslić i okolina",
						to: "/mapa"
					})])];
				}),
				_: 1
			}, _parent));
			if (preporuceni.value.length) _push(ssrRenderComponent(_sfc_main$98, { class: "mt-12" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<h2 class="mb-6 font-heading text-2xl font-bold text-heading"${_scopeId}>Preporučene lokacije</h2>`);
						_push(ssrRenderComponent(_sfc_main$90, { cols: 3 }, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`<!--[-->`);
									ssrRenderList(preporuceni.value, (l) => {
										_push(ssrRenderComponent(_sfc_main$63, {
											key: l.slug,
											item: l
										}, null, _parent, _scopeId));
									});
									_push(`<!--]-->`);
								} else return [(openBlock(true), createBlock(Fragment, null, renderList(preporuceni.value, (l) => {
									return openBlock(), createBlock(_sfc_main$63, {
										key: l.slug,
										item: l
									}, null, 8, ["item"]);
								}), 128))];
							}),
							_: 1
						}, _parent, _scopeId));
					} else return [createVNode("h2", { class: "mb-6 font-heading text-2xl font-bold text-heading" }, "Preporučene lokacije"), createVNode(_sfc_main$90, { cols: 3 }, {
						default: withCtx(() => [(openBlock(true), createBlock(Fragment, null, renderList(preporuceni.value, (l) => {
							return openBlock(), createBlock(_sfc_main$63, {
								key: l.slug,
								item: l
							}, null, 8, ["item"]);
						}), 128))]),
						_: 1
					})];
				}),
				_: 1
			}, _parent));
			else _push(`<!---->`);
			_push(`</main>`);
		};
	}
};
var _sfc_setup$21 = _sfc_main$21.setup;
_sfc_main$21.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/TourismListing.vue");
	return _sfc_setup$21 ? _sfc_setup$21(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/Welcome.vue
var Welcome_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$20 });
var _sfc_main$20 = {
	__name: "Welcome",
	__ssrInlineRender: true,
	props: {
		naziv: String,
		poruka: String
	},
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex min-h-screen flex-col items-center justify-center gap-3 bg-white text-center" }, _attrs))}><h1 class="text-3xl font-semibold text-[#0E8275]">${ssrInterpolate(__props.naziv)}</h1><p class="text-gray-600">${ssrInterpolate(__props.poruka)}</p></div>`);
		};
	}
};
var _sfc_setup$20 = _sfc_main$20.setup;
_sfc_main$20.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Welcome.vue");
	return _sfc_setup$20 ? _sfc_setup$20(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/account/AccountSidebar.vue
var _sfc_main$19 = {
	__name: "AccountSidebar",
	__ssrInlineRender: true,
	props: {
		heading: {
			type: String,
			default: "MOJ NALOG"
		},
		items: {
			type: Array,
			required: true
		}
	},
	setup(__props) {
		const page = usePage();
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<nav${ssrRenderAttrs(mergeProps({ class: "w-60 shrink-0 rounded-md border border-border bg-surface p-3" }, _attrs))}><p class="px-3 pb-2 pt-1 text-xs font-bold uppercase tracking-wider text-text-muted">${ssrInterpolate(__props.heading)}</p><!--[-->`);
			ssrRenderList(__props.items, (it) => {
				_push(ssrRenderComponent(unref(Link), {
					key: it.to,
					href: it.to,
					class: ["flex items-center gap-3 rounded-md px-3 py-2.5 text-[15px] transition-colors", unref(page).url === it.to ? "bg-primary-tint font-semibold text-primary" : "text-text hover:bg-surface-alt"]
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) {
							_push(ssrRenderComponent(_sfc_main$97, {
								name: it.icon,
								size: 18,
								class: unref(page).url === it.to ? "text-primary" : "text-text-muted"
							}, null, _parent, _scopeId));
							_push(` ${ssrInterpolate(it.label)}`);
						} else return [createVNode(_sfc_main$97, {
							name: it.icon,
							size: 18,
							class: unref(page).url === it.to ? "text-primary" : "text-text-muted"
						}, null, 8, ["name", "class"]), createTextVNode(" " + toDisplayString(it.label), 1)];
					}),
					_: 2
				}, _parent));
			});
			_push(`<!--]--></nav>`);
		};
	}
};
var _sfc_setup$19 = _sfc_main$19.setup;
_sfc_main$19.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/account/AccountSidebar.vue");
	return _sfc_setup$19 ? _sfc_setup$19(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/layout/AccountLayout.vue
var _sfc_main$18 = {
	__name: "AccountLayout",
	__ssrInlineRender: true,
	props: {
		items: {
			type: Array,
			required: true
		},
		heading: {
			type: String,
			default: "MOJ NALOG"
		},
		initials: {
			type: String,
			default: ""
		}
	},
	setup(__props) {
		const page = usePage();
		const props = __props;
		const userInitials = computed(() => {
			if (props.initials) return props.initials;
			return (page.props.auth?.user?.name || "").split(" ").map((p) => p[0]).slice(0, 2).join("").toUpperCase();
		});
		function logout() {
			router.post("/logout");
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex min-h-screen flex-col bg-surface-alt" }, _attrs))}><header class="flex items-center gap-4 border-b border-border bg-surface px-4 py-3.5 md:px-8">`);
			_push(ssrRenderComponent(unref(Link), {
				href: "/",
				class: "text-2xl font-extrabold tracking-tight text-primary"
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(`teslić`);
					else return [createTextVNode("teslić")];
				}),
				_: 1
			}, _parent));
			_push(`<span class="hidden text-[15px] font-medium text-text-muted sm:inline">Moj nalog</span><div class="ml-auto flex items-center gap-3"><span class="flex size-9 items-center justify-center rounded-full bg-primary-tint text-[13px] font-bold text-primary">${ssrInterpolate(userInitials.value)}</span>`);
			_push(ssrRenderComponent(_sfc_main$93, {
				variant: "ghost",
				size: "sm",
				icon: "log-out",
				onClick: logout
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(`Odjava`);
					else return [createTextVNode("Odjava")];
				}),
				_: 1
			}, _parent));
			_push(`</div></header><nav class="flex gap-2 overflow-x-auto border-b border-border bg-surface px-4 py-3 lg:hidden"><!--[-->`);
			ssrRenderList(__props.items, (it) => {
				_push(ssrRenderComponent(unref(Link), {
					key: it.to,
					href: it.to,
					class: ["shrink-0 rounded-pill px-3.5 py-2 text-[13px] font-medium transition-colors", unref(page).url === it.to ? "bg-primary text-white" : "bg-surface-alt text-text-muted"]
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(`${ssrInterpolate(it.label)}`);
						else return [createTextVNode(toDisplayString(it.label), 1)];
					}),
					_: 2
				}, _parent));
			});
			_push(`<!--]--></nav><div class="flex flex-1 gap-8 px-4 py-6 md:px-8 md:py-8"><div class="hidden lg:block">`);
			_push(ssrRenderComponent(_sfc_main$19, {
				items: __props.items,
				heading: __props.heading
			}, null, _parent));
			_push(`</div><main class="min-w-0 flex-1">`);
			ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
			_push(`</main></div></div>`);
		};
	}
};
var _sfc_setup$18 = _sfc_main$18.setup;
_sfc_main$18.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/AccountLayout.vue");
	return _sfc_setup$18 ? _sfc_setup$18(props, ctx) : void 0;
};
//#endregion
//#region resources/js/constants/account.js
var biznisNav = [
	{
		label: "Moj profil",
		icon: "user",
		to: "/nalog/biznis/profil"
	},
	{
		label: "Moje objave",
		icon: "file-text",
		to: "/nalog/biznis/objave"
	},
	{
		label: "Nova objava",
		icon: "plus",
		to: "/nalog/biznis/objave/nova"
	},
	{
		label: "Oglasi",
		icon: "megaphone",
		to: "/nalog/biznis/oglasi"
	},
	{
		label: "Postavke",
		icon: "settings",
		to: "/nalog/biznis/postavke"
	}
];
var autorNav = [
	{
		label: "Moje priče",
		icon: "file-text",
		to: "/nalog/autor/price"
	},
	{
		label: "Nova priča",
		icon: "pencil",
		to: "/nalog/autor/nova-prica"
	},
	{
		label: "Autorski profil",
		icon: "user",
		to: "/nalog/autor/profil"
	},
	{
		label: "Postavke",
		icon: "settings",
		to: "/nalog/autor/postavke"
	}
];
//#endregion
//#region resources/js/Pages/account/AutorNovaPrica.vue
var AutorNovaPrica_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$17 });
var _sfc_main$17 = {
	__name: "AutorNovaPrica",
	__ssrInlineRender: true,
	props: {
		story: {
			type: Object,
			default: null
		},
		kategorije: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const form = useForm({
			naslov: props.story?.naslov ?? "",
			category_id: props.story?.category_id ?? null,
			izvod: props.story?.izvod ?? "",
			sadrzaj: props.story?.sadrzaj ?? "",
			action: "nacrt"
		});
		function submit(action) {
			form.action = action;
			if (props.story) form.put(`/nalog/autor/price/${props.story.id}`);
			else form.post("/nalog/autor/price");
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(autorNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>${ssrInterpolate(__props.story ? "Uredi priču" : "Nova priča")}</h1><p class="mt-1 text-[15px] text-text-muted"${_scopeId}> Napišite priču i pošaljite je na odobrenje administratoru. </p></div>`);
						if (Object.keys(unref(form).errors).length) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Naslov je obavezan."
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7"${_scopeId}><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).naslov,
							"onUpdate:modelValue": ($event) => unref(form).naslov = $event,
							label: "Naslov",
							error: unref(form).errors.naslov
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$78, {
							modelValue: unref(form).category_id,
							"onUpdate:modelValue": ($event) => unref(form).category_id = $event,
							label: "Kategorija",
							placeholder: "Odaberite kategoriju",
							options: __props.kategorije
						}, null, _parent, _scopeId));
						_push(`</div>`);
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: unref(form).izvod,
							"onUpdate:modelValue": ($event) => unref(form).izvod = $event,
							label: "Kratak izvod",
							rows: 2
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: unref(form).sadrzaj,
							"onUpdate:modelValue": ($event) => unref(form).sadrzaj = $event,
							label: "Sadržaj priče",
							rows: 10
						}, null, _parent, _scopeId));
						_push(`</div><div class="flex flex-wrap justify-end gap-3"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "secondary",
							icon: "save",
							disabled: unref(form).processing,
							onClick: ($event) => submit("nacrt")
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Sačuvaj nacrt `);
								else return [createTextVNode(" Sačuvaj nacrt ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "primary",
							icon: "send",
							disabled: unref(form).processing,
							onClick: ($event) => submit("posalji")
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Pošalji na odobrenje `);
								else return [createTextVNode(" Pošalji na odobrenje ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div></div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [
						createVNode("div", null, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, toDisplayString(__props.story ? "Uredi priču" : "Nova priča"), 1), createVNode("p", { class: "mt-1 text-[15px] text-text-muted" }, " Napišite priču i pošaljite je na odobrenje administratoru. ")]),
						Object.keys(unref(form).errors).length ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Naslov je obavezan."
						})) : createCommentVNode("", true),
						createVNode("div", { class: "space-y-6 rounded-md border border-border bg-surface p-6 md:p-7" }, [
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).naslov,
								"onUpdate:modelValue": ($event) => unref(form).naslov = $event,
								label: "Naslov",
								error: unref(form).errors.naslov
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]), createVNode(_sfc_main$78, {
								modelValue: unref(form).category_id,
								"onUpdate:modelValue": ($event) => unref(form).category_id = $event,
								label: "Kategorija",
								placeholder: "Odaberite kategoriju",
								options: __props.kategorije
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"options"
							])]),
							createVNode(_sfc_main$67, {
								modelValue: unref(form).izvod,
								"onUpdate:modelValue": ($event) => unref(form).izvod = $event,
								label: "Kratak izvod",
								rows: 2
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$67, {
								modelValue: unref(form).sadrzaj,
								"onUpdate:modelValue": ($event) => unref(form).sadrzaj = $event,
								label: "Sadržaj priče",
								rows: 10
							}, null, 8, ["modelValue", "onUpdate:modelValue"])
						]),
						createVNode("div", { class: "flex flex-wrap justify-end gap-3" }, [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "save",
							disabled: unref(form).processing,
							onClick: ($event) => submit("nacrt")
						}, {
							default: withCtx(() => [createTextVNode(" Sačuvaj nacrt ")]),
							_: 1
						}, 8, ["disabled", "onClick"]), createVNode(_sfc_main$93, {
							variant: "primary",
							icon: "send",
							disabled: unref(form).processing,
							onClick: ($event) => submit("posalji")
						}, {
							default: withCtx(() => [createTextVNode(" Pošalji na odobrenje ")]),
							_: 1
						}, 8, ["disabled", "onClick"])])
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$17 = _sfc_main$17.setup;
_sfc_main$17.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/AutorNovaPrica.vue");
	return _sfc_setup$17 ? _sfc_setup$17(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/account/SettingsPanel.vue
var _sfc_main$16 = {
	__name: "SettingsPanel",
	__ssrInlineRender: true,
	setup(__props) {
		const page = usePage();
		const status = computed(() => page.props.flash?.status);
		const user = computed(() => page.props.auth?.user || {});
		const profil = useForm({
			name: user.value.name ?? "",
			email: user.value.email ?? ""
		});
		const lozinka = useForm({
			current_password: "",
			password: "",
			password_confirmation: ""
		});
		function sacuvajProfil() {
			profil.put("/user/profile-information", { preserveScroll: true });
		}
		function promijeniLozinku() {
			lozinka.put("/user/password", {
				preserveScroll: true,
				onSuccess: () => lozinka.reset()
			});
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "space-y-6" }, _attrs))}><div><h1 class="font-heading text-[28px] font-bold text-heading">Postavke</h1><p class="mt-1 text-[15px] text-text-muted">Upravljajte podacima naloga i lozinkom.</p></div>`);
			if (status.value) _push(ssrRenderComponent(_sfc_main$86, {
				variant: "uspjeh",
				title: "Sačuvano",
				text: status.value
			}, null, _parent));
			else _push(`<!---->`);
			_push(`<div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7"><h2 class="font-heading text-lg font-bold text-heading">Podaci naloga</h2><div class="grid gap-5 md:grid-cols-2">`);
			_push(ssrRenderComponent(_sfc_main$68, {
				modelValue: unref(profil).name,
				"onUpdate:modelValue": ($event) => unref(profil).name = $event,
				label: "Ime / naziv",
				error: unref(profil).errors.name
			}, null, _parent));
			_push(ssrRenderComponent(_sfc_main$68, {
				modelValue: unref(profil).email,
				"onUpdate:modelValue": ($event) => unref(profil).email = $event,
				label: "E-mail",
				type: "email",
				error: unref(profil).errors.email
			}, null, _parent));
			_push(`</div><div class="flex justify-end">`);
			_push(ssrRenderComponent(_sfc_main$93, {
				variant: "primary",
				icon: "check",
				disabled: unref(profil).processing,
				onClick: sacuvajProfil
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(` Sačuvaj podatke `);
					else return [createTextVNode(" Sačuvaj podatke ")];
				}),
				_: 1
			}, _parent));
			_push(`</div></div><div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7"><h2 class="font-heading text-lg font-bold text-heading">Promjena lozinke</h2>`);
			_push(ssrRenderComponent(_sfc_main$68, {
				modelValue: unref(lozinka).current_password,
				"onUpdate:modelValue": ($event) => unref(lozinka).current_password = $event,
				label: "Trenutna lozinka",
				type: "password",
				error: unref(lozinka).errors.current_password
			}, null, _parent));
			_push(`<div class="grid gap-5 md:grid-cols-2">`);
			_push(ssrRenderComponent(_sfc_main$68, {
				modelValue: unref(lozinka).password,
				"onUpdate:modelValue": ($event) => unref(lozinka).password = $event,
				label: "Nova lozinka",
				type: "password",
				error: unref(lozinka).errors.password
			}, null, _parent));
			_push(ssrRenderComponent(_sfc_main$68, {
				modelValue: unref(lozinka).password_confirmation,
				"onUpdate:modelValue": ($event) => unref(lozinka).password_confirmation = $event,
				label: "Potvrdi novu lozinku",
				type: "password",
				helper: "Najmanje 8 znakova"
			}, null, _parent));
			_push(`</div><div class="flex justify-end">`);
			_push(ssrRenderComponent(_sfc_main$93, {
				variant: "secondary",
				icon: "key",
				disabled: unref(lozinka).processing,
				onClick: promijeniLozinku
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(` Promijeni lozinku `);
					else return [createTextVNode(" Promijeni lozinku ")];
				}),
				_: 1
			}, _parent));
			_push(`</div></div></div>`);
		};
	}
};
var _sfc_setup$16 = _sfc_main$16.setup;
_sfc_main$16.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/account/SettingsPanel.vue");
	return _sfc_setup$16 ? _sfc_setup$16(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/AutorPostavke.vue
var AutorPostavke_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$15 });
var _sfc_main$15 = {
	__name: "AutorPostavke",
	__ssrInlineRender: true,
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(autorNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$16, null, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$16)];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$15 = _sfc_main$15.setup;
_sfc_main$15.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/AutorPostavke.vue");
	return _sfc_setup$15 ? _sfc_setup$15(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/account/PostRow.vue
var _sfc_main$14 = {
	__name: "PostRow",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	emits: ["edit", "delete"],
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "overflow-hidden rounded-md border border-border bg-surface" }, _attrs))}><div class="flex items-center gap-4 p-4"><div class="size-14 shrink-0 overflow-hidden rounded-md bg-primary-tint">`);
			if (__props.item.thumb) _push(`<img${ssrRenderAttr("src", __props.item.thumb)} alt="" class="size-full object-cover">`);
			else _push(`<!---->`);
			_push(`</div><div class="min-w-0 flex-1"><p class="truncate font-semibold text-heading">${ssrInterpolate(__props.item.naslov)}</p><p class="text-[13px] text-text-muted">${ssrInterpolate(__props.item.meta)}</p></div>`);
			if (__props.item.status) _push(ssrRenderComponent(_sfc_main$87, { variant: __props.item.status }, null, _parent));
			else _push(`<!---->`);
			_push(`<div class="flex gap-2"><button type="button" class="grid size-9 place-items-center rounded-md bg-surface-alt text-text-muted hover:text-primary" aria-label="Uredi">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "pencil",
				size: 16
			}, null, _parent));
			_push(`</button><button type="button" class="grid size-9 place-items-center rounded-md bg-surface-alt text-text-muted hover:text-error" aria-label="Obriši">`);
			_push(ssrRenderComponent(_sfc_main$97, {
				name: "trash-2",
				size: 16
			}, null, _parent));
			_push(`</button></div></div>`);
			if (__props.item.reason) {
				_push(`<div class="flex items-start gap-2 border-t border-border bg-error-tint px-4 py-2.5 text-[13px] text-error">`);
				_push(ssrRenderComponent(_sfc_main$97, {
					name: "info",
					size: 16,
					class: "mt-0.5 shrink-0"
				}, null, _parent));
				_push(`<span>${ssrInterpolate(__props.item.reason)}</span></div>`);
			} else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$14 = _sfc_main$14.setup;
_sfc_main$14.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/account/PostRow.vue");
	return _sfc_setup$14 ? _sfc_setup$14(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/AutorPrice.vue
var AutorPrice_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$13 });
var _sfc_main$13 = {
	__name: "AutorPrice",
	__ssrInlineRender: true,
	props: { price: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(autorNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"${_scopeId}><div${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>Moje priče</h1><p class="mt-1 text-[15px] text-text-muted"${_scopeId}>Vaše objavljene i sačuvane priče.</p></div>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							to: "/nalog/autor/nova-prica",
							variant: "primary",
							icon: "plus"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Nova priča`);
								else return [createTextVNode("Nova priča")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div>`);
						if (__props.price.length) {
							_push(`<div class="space-y-3"${_scopeId}><!--[-->`);
							ssrRenderList(__props.price, (p) => {
								_push(ssrRenderComponent(unref(Link), {
									key: p.id,
									href: p.editUrl,
									class: "block"
								}, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(ssrRenderComponent(_sfc_main$14, { item: p }, null, _parent, _scopeId));
										else return [createVNode(_sfc_main$14, { item: p }, null, 8, ["item"])];
									}),
									_: 2
								}, _parent, _scopeId));
							});
							_push(`<!--]--></div>`);
						} else _push(ssrRenderComponent(_sfc_main$85, {
							title: "Još nema priča",
							text: "Kreirajte prvu priču i pošaljite je na odobrenje."
						}, null, _parent, _scopeId));
						_push(`</div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [createVNode("div", { class: "flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" }, [createVNode("div", null, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, "Moje priče"), createVNode("p", { class: "mt-1 text-[15px] text-text-muted" }, "Vaše objavljene i sačuvane priče.")]), createVNode(_sfc_main$93, {
						to: "/nalog/autor/nova-prica",
						variant: "primary",
						icon: "plus"
					}, {
						default: withCtx(() => [createTextVNode("Nova priča")]),
						_: 1
					})]), __props.price.length ? (openBlock(), createBlock("div", {
						key: 0,
						class: "space-y-3"
					}, [(openBlock(true), createBlock(Fragment, null, renderList(__props.price, (p) => {
						return openBlock(), createBlock(unref(Link), {
							key: p.id,
							href: p.editUrl,
							class: "block"
						}, {
							default: withCtx(() => [createVNode(_sfc_main$14, { item: p }, null, 8, ["item"])]),
							_: 2
						}, 1032, ["href"]);
					}), 128))])) : (openBlock(), createBlock(_sfc_main$85, {
						key: 1,
						title: "Još nema priča",
						text: "Kreirajte prvu priču i pošaljite je na odobrenje."
					}))])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$13 = _sfc_main$13.setup;
_sfc_main$13.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/AutorPrice.vue");
	return _sfc_setup$13 ? _sfc_setup$13(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/AutorProfil.vue
var AutorProfil_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$12 });
var _sfc_main$12 = {
	__name: "AutorProfil",
	__ssrInlineRender: true,
	props: { profil: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		const props = __props;
		const form = useForm({
			name: props.profil.name ?? "",
			bio: props.profil.bio ?? "",
			avatar: null
		});
		const preview = computed(() => {
			if (form.avatar) return URL.createObjectURL(form.avatar);
			return props.profil.avatar || "";
		});
		const initials = computed(() => (form.name || "").split(" ").map((p) => p[0]).slice(0, 2).join("").toUpperCase());
		function onAvatar(e) {
			form.avatar = e.target.files[0] ?? null;
		}
		function submit() {
			form.post("/nalog/autor/profil", { preserveScroll: true });
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(autorNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>Autorski profil</h1><p class="mt-1 text-[15px] text-text-muted"${_scopeId}>Vaše javne informacije kao autora priča.</p></div>`);
						if (_ctx.$page.props.flash?.status) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "uspjeh",
							title: "Sačuvano",
							text: _ctx.$page.props.flash.status
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7"${_scopeId}><div class="flex items-center gap-5"${_scopeId}><span class="size-18 shrink-0 overflow-hidden rounded-full bg-primary-tint"${_scopeId}>`);
						if (preview.value) _push(`<img${ssrRenderAttr("src", preview.value)} alt="" class="size-full object-cover"${_scopeId}>`);
						else _push(`<span class="flex size-full items-center justify-center text-2xl font-bold text-primary"${_scopeId}>${ssrInterpolate(initials.value)}</span>`);
						_push(`</span><label class="cursor-pointer"${_scopeId}><span class="inline-flex items-center rounded-sm border border-border px-3 py-2 text-sm font-semibold text-heading hover:bg-surface-alt"${_scopeId}> Promijeni fotografiju </span><input type="file" accept="image/*" class="hidden"${_scopeId}></label></div>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).name,
							"onUpdate:modelValue": ($event) => unref(form).name = $event,
							label: "Ime i prezime",
							error: unref(form).errors.name
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: unref(form).bio,
							"onUpdate:modelValue": ($event) => unref(form).bio = $event,
							label: "Biografija",
							rows: 4,
							maxlength: 1e3
						}, null, _parent, _scopeId));
						_push(`<div class="flex justify-end"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "primary",
							icon: "check",
							disabled: unref(form).processing,
							onClick: submit
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Sačuvaj profil `);
								else return [createTextVNode(" Sačuvaj profil ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div></div></div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [
						createVNode("div", null, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, "Autorski profil"), createVNode("p", { class: "mt-1 text-[15px] text-text-muted" }, "Vaše javne informacije kao autora priča.")]),
						_ctx.$page.props.flash?.status ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "uspjeh",
							title: "Sačuvano",
							text: _ctx.$page.props.flash.status
						}, null, 8, ["text"])) : createCommentVNode("", true),
						createVNode("div", { class: "space-y-6 rounded-md border border-border bg-surface p-6 md:p-7" }, [
							createVNode("div", { class: "flex items-center gap-5" }, [createVNode("span", { class: "size-18 shrink-0 overflow-hidden rounded-full bg-primary-tint" }, [preview.value ? (openBlock(), createBlock("img", {
								key: 0,
								src: preview.value,
								alt: "",
								class: "size-full object-cover"
							}, null, 8, ["src"])) : (openBlock(), createBlock("span", {
								key: 1,
								class: "flex size-full items-center justify-center text-2xl font-bold text-primary"
							}, toDisplayString(initials.value), 1))]), createVNode("label", { class: "cursor-pointer" }, [createVNode("span", { class: "inline-flex items-center rounded-sm border border-border px-3 py-2 text-sm font-semibold text-heading hover:bg-surface-alt" }, " Promijeni fotografiju "), createVNode("input", {
								type: "file",
								accept: "image/*",
								class: "hidden",
								onChange: onAvatar
							}, null, 32)])]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).name,
								"onUpdate:modelValue": ($event) => unref(form).name = $event,
								label: "Ime i prezime",
								error: unref(form).errors.name
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]),
							createVNode(_sfc_main$67, {
								modelValue: unref(form).bio,
								"onUpdate:modelValue": ($event) => unref(form).bio = $event,
								label: "Biografija",
								rows: 4,
								maxlength: 1e3
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode("div", { class: "flex justify-end" }, [createVNode(_sfc_main$93, {
								variant: "primary",
								icon: "check",
								disabled: unref(form).processing,
								onClick: submit
							}, {
								default: withCtx(() => [createTextVNode(" Sačuvaj profil ")]),
								_: 1
							}, 8, ["disabled"])])
						])
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$12 = _sfc_main$12.setup;
_sfc_main$12.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/AutorProfil.vue");
	return _sfc_setup$12 ? _sfc_setup$12(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/BiznisObjavaForm.vue
var BiznisObjavaForm_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$11 });
var _sfc_main$11 = {
	__name: "BiznisObjavaForm",
	__ssrInlineRender: true,
	props: {
		objava: {
			type: Object,
			default: null
		},
		kategorije: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const form = useForm({
			naslov: props.objava?.naslov ?? "",
			category_id: props.objava?.category_id ?? null,
			opis: props.objava?.opis ?? "",
			opis_dug: props.objava?.opis_dug ?? "",
			lokacija: props.objava?.lokacija ?? "",
			kontakt: {
				telefon: props.objava?.kontakt?.telefon ?? "",
				email: props.objava?.kontakt?.email ?? "",
				web: props.objava?.kontakt?.web ?? "",
				radnoVrijeme: props.objava?.kontakt?.radnoVrijeme ?? "",
				adresa: props.objava?.kontakt?.adresa ?? ""
			},
			lat: props.objava?.lat ?? "",
			lng: props.objava?.lng ?? "",
			naslovna: null,
			galerija: [],
			action: "nacrt"
		});
		function onNaslovna(e) {
			form.naslovna = e.target.files[0] ?? null;
		}
		function onGalerija(e) {
			form.galerija = Array.from(e.target.files);
		}
		function submit(action) {
			form.action = action;
			const url = props.objava ? `/nalog/biznis/objave/${props.objava.id}` : "/nalog/biznis/objave";
			form.post(url, { preserveScroll: true });
		}
		function ukloniMedij(id) {
			router.delete(`/nalog/biznis/objave/medij/${id}`, { preserveScroll: true });
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(biznisNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div class="flex items-center gap-3"${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>${ssrInterpolate(__props.objava ? "Uredi objavu" : "Nova objava")}</h1>`);
						if (__props.objava) _push(ssrRenderComponent(_sfc_main$87, { variant: __props.objava.status }, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`</div>`);
						if (_ctx.$page.props.flash?.status) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "uspjeh",
							title: "Sačuvano",
							text: _ctx.$page.props.flash.status
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						if (unref(form).errors.naslov) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "greska",
							title: "Provjerite podatke",
							text: "Naziv je obavezan."
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7"${_scopeId}><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).naslov,
							"onUpdate:modelValue": ($event) => unref(form).naslov = $event,
							label: "Naziv",
							error: unref(form).errors.naslov
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$78, {
							modelValue: unref(form).category_id,
							"onUpdate:modelValue": ($event) => unref(form).category_id = $event,
							label: "Kategorija",
							placeholder: "Odaberite kategoriju",
							options: __props.kategorije
						}, null, _parent, _scopeId));
						_push(`</div>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).opis,
							"onUpdate:modelValue": ($event) => unref(form).opis = $event,
							label: "Kratak opis"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: unref(form).opis_dug,
							"onUpdate:modelValue": ($event) => unref(form).opis_dug = $event,
							label: "Detaljan opis",
							rows: 5
						}, null, _parent, _scopeId));
						_push(`<div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).lokacija,
							"onUpdate:modelValue": ($event) => unref(form).lokacija = $event,
							label: "Lokacija (tekst)"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).kontakt.adresa,
							"onUpdate:modelValue": ($event) => unref(form).kontakt.adresa = $event,
							label: "Adresa"
						}, null, _parent, _scopeId));
						_push(`</div><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).kontakt.telefon,
							"onUpdate:modelValue": ($event) => unref(form).kontakt.telefon = $event,
							label: "Telefon",
							type: "tel"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).kontakt.email,
							"onUpdate:modelValue": ($event) => unref(form).kontakt.email = $event,
							label: "E-mail",
							type: "email"
						}, null, _parent, _scopeId));
						_push(`</div><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).kontakt.web,
							"onUpdate:modelValue": ($event) => unref(form).kontakt.web = $event,
							label: "Web"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).kontakt.radnoVrijeme,
							"onUpdate:modelValue": ($event) => unref(form).kontakt.radnoVrijeme = $event,
							label: "Radno vrijeme"
						}, null, _parent, _scopeId));
						_push(`</div><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).lat,
							"onUpdate:modelValue": ($event) => unref(form).lat = $event,
							label: "Geo. širina (lat)"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).lng,
							"onUpdate:modelValue": ($event) => unref(form).lng = $event,
							label: "Geo. dužina (lng)"
						}, null, _parent, _scopeId));
						_push(`</div></div><div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7"${_scopeId}><h2 class="font-heading text-lg font-bold text-heading"${_scopeId}>Fotografije</h2><div class="grid gap-5 md:grid-cols-2"${_scopeId}><div class="space-y-2"${_scopeId}><p class="text-sm font-semibold text-heading"${_scopeId}>Naslovna</p><div class="mb-2 flex h-32 items-center justify-center overflow-hidden rounded-md bg-primary-tint"${_scopeId}>`);
						if (__props.objava?.naslovna) _push(`<img${ssrRenderAttr("src", __props.objava.naslovna)} alt="" class="size-full object-cover"${_scopeId}>`);
						else _push(ssrRenderComponent(_sfc_main$97, {
							name: "image",
							size: 28,
							class: "text-primary-tint-2"
						}, null, _parent, _scopeId));
						_push(`</div><input type="file" accept="image/*"${_scopeId}></div><div class="space-y-2"${_scopeId}><p class="text-sm font-semibold text-heading"${_scopeId}>Dodaj u galeriju</p><input type="file" accept="image/*" multiple${_scopeId}></div></div>`);
						if (__props.objava?.galerija?.length) {
							_push(`<div class="grid grid-cols-3 gap-3 sm:grid-cols-4"${_scopeId}><!--[-->`);
							ssrRenderList(__props.objava.galerija, (m) => {
								_push(`<div class="relative h-28 overflow-hidden rounded-md bg-primary-tint"${_scopeId}><img${ssrRenderAttr("src", m.src)} alt="" class="size-full object-cover"${_scopeId}><button type="button" class="absolute right-1.5 top-1.5 inline-flex size-7 items-center justify-center rounded-full bg-surface/90 text-error" aria-label="Ukloni"${_scopeId}>`);
								_push(ssrRenderComponent(_sfc_main$97, {
									name: "trash-2",
									size: 14
								}, null, _parent, _scopeId));
								_push(`</button></div>`);
							});
							_push(`<!--]--></div>`);
						} else _push(`<!---->`);
						_push(`</div><div class="flex flex-wrap justify-end gap-3"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "secondary",
							icon: "save",
							disabled: unref(form).processing,
							onClick: ($event) => submit("nacrt")
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Sačuvaj nacrt `);
								else return [createTextVNode(" Sačuvaj nacrt ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "primary",
							icon: "send",
							disabled: unref(form).processing,
							onClick: ($event) => submit("posalji")
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Pošalji na odobrenje `);
								else return [createTextVNode(" Pošalji na odobrenje ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div></div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [
						createVNode("div", { class: "flex items-center gap-3" }, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, toDisplayString(__props.objava ? "Uredi objavu" : "Nova objava"), 1), __props.objava ? (openBlock(), createBlock(_sfc_main$87, {
							key: 0,
							variant: __props.objava.status
						}, null, 8, ["variant"])) : createCommentVNode("", true)]),
						_ctx.$page.props.flash?.status ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "uspjeh",
							title: "Sačuvano",
							text: _ctx.$page.props.flash.status
						}, null, 8, ["text"])) : createCommentVNode("", true),
						unref(form).errors.naslov ? (openBlock(), createBlock(_sfc_main$86, {
							key: 1,
							variant: "greska",
							title: "Provjerite podatke",
							text: "Naziv je obavezan."
						})) : createCommentVNode("", true),
						createVNode("div", { class: "space-y-6 rounded-md border border-border bg-surface p-6 md:p-7" }, [
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).naslov,
								"onUpdate:modelValue": ($event) => unref(form).naslov = $event,
								label: "Naziv",
								error: unref(form).errors.naslov
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]), createVNode(_sfc_main$78, {
								modelValue: unref(form).category_id,
								"onUpdate:modelValue": ($event) => unref(form).category_id = $event,
								label: "Kategorija",
								placeholder: "Odaberite kategoriju",
								options: __props.kategorije
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"options"
							])]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).opis,
								"onUpdate:modelValue": ($event) => unref(form).opis = $event,
								label: "Kratak opis"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$67, {
								modelValue: unref(form).opis_dug,
								"onUpdate:modelValue": ($event) => unref(form).opis_dug = $event,
								label: "Detaljan opis",
								rows: 5
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).lokacija,
								"onUpdate:modelValue": ($event) => unref(form).lokacija = $event,
								label: "Lokacija (tekst)"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$68, {
								modelValue: unref(form).kontakt.adresa,
								"onUpdate:modelValue": ($event) => unref(form).kontakt.adresa = $event,
								label: "Adresa"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).kontakt.telefon,
								"onUpdate:modelValue": ($event) => unref(form).kontakt.telefon = $event,
								label: "Telefon",
								type: "tel"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$68, {
								modelValue: unref(form).kontakt.email,
								"onUpdate:modelValue": ($event) => unref(form).kontakt.email = $event,
								label: "E-mail",
								type: "email"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).kontakt.web,
								"onUpdate:modelValue": ($event) => unref(form).kontakt.web = $event,
								label: "Web"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$68, {
								modelValue: unref(form).kontakt.radnoVrijeme,
								"onUpdate:modelValue": ($event) => unref(form).kontakt.radnoVrijeme = $event,
								label: "Radno vrijeme"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).lat,
								"onUpdate:modelValue": ($event) => unref(form).lat = $event,
								label: "Geo. širina (lat)"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$68, {
								modelValue: unref(form).lng,
								"onUpdate:modelValue": ($event) => unref(form).lng = $event,
								label: "Geo. dužina (lng)"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])])
						]),
						createVNode("div", { class: "space-y-5 rounded-md border border-border bg-surface p-6 md:p-7" }, [
							createVNode("h2", { class: "font-heading text-lg font-bold text-heading" }, "Fotografije"),
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode("div", { class: "space-y-2" }, [
								createVNode("p", { class: "text-sm font-semibold text-heading" }, "Naslovna"),
								createVNode("div", { class: "mb-2 flex h-32 items-center justify-center overflow-hidden rounded-md bg-primary-tint" }, [__props.objava?.naslovna ? (openBlock(), createBlock("img", {
									key: 0,
									src: __props.objava.naslovna,
									alt: "",
									class: "size-full object-cover"
								}, null, 8, ["src"])) : (openBlock(), createBlock(_sfc_main$97, {
									key: 1,
									name: "image",
									size: 28,
									class: "text-primary-tint-2"
								}))]),
								createVNode("input", {
									type: "file",
									accept: "image/*",
									onChange: onNaslovna
								}, null, 32)
							]), createVNode("div", { class: "space-y-2" }, [createVNode("p", { class: "text-sm font-semibold text-heading" }, "Dodaj u galeriju"), createVNode("input", {
								type: "file",
								accept: "image/*",
								multiple: "",
								onChange: onGalerija
							}, null, 32)])]),
							__props.objava?.galerija?.length ? (openBlock(), createBlock("div", {
								key: 0,
								class: "grid grid-cols-3 gap-3 sm:grid-cols-4"
							}, [(openBlock(true), createBlock(Fragment, null, renderList(__props.objava.galerija, (m) => {
								return openBlock(), createBlock("div", {
									key: m.id,
									class: "relative h-28 overflow-hidden rounded-md bg-primary-tint"
								}, [createVNode("img", {
									src: m.src,
									alt: "",
									class: "size-full object-cover"
								}, null, 8, ["src"]), createVNode("button", {
									type: "button",
									class: "absolute right-1.5 top-1.5 inline-flex size-7 items-center justify-center rounded-full bg-surface/90 text-error",
									"aria-label": "Ukloni",
									onClick: ($event) => ukloniMedij(m.id)
								}, [createVNode(_sfc_main$97, {
									name: "trash-2",
									size: 14
								})], 8, ["onClick"])]);
							}), 128))])) : createCommentVNode("", true)
						]),
						createVNode("div", { class: "flex flex-wrap justify-end gap-3" }, [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "save",
							disabled: unref(form).processing,
							onClick: ($event) => submit("nacrt")
						}, {
							default: withCtx(() => [createTextVNode(" Sačuvaj nacrt ")]),
							_: 1
						}, 8, ["disabled", "onClick"]), createVNode(_sfc_main$93, {
							variant: "primary",
							icon: "send",
							disabled: unref(form).processing,
							onClick: ($event) => submit("posalji")
						}, {
							default: withCtx(() => [createTextVNode(" Pošalji na odobrenje ")]),
							_: 1
						}, 8, ["disabled", "onClick"])])
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$11 = _sfc_main$11.setup;
_sfc_main$11.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/BiznisObjavaForm.vue");
	return _sfc_setup$11 ? _sfc_setup$11(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/BiznisObjave.vue
var BiznisObjave_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$10 });
var _sfc_main$10 = {
	__name: "BiznisObjave",
	__ssrInlineRender: true,
	props: { objave: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(biznisNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"${_scopeId}><div${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>Moje objave</h1><p class="mt-1 text-[15px] text-text-muted"${_scopeId}>Vaše biznis objave i njihov status.</p></div>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							to: "/nalog/biznis/objave/nova",
							variant: "primary",
							icon: "plus"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Nova objava`);
								else return [createTextVNode("Nova objava")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div>`);
						if (__props.objave.length) {
							_push(`<div class="space-y-3"${_scopeId}><!--[-->`);
							ssrRenderList(__props.objave, (o) => {
								_push(ssrRenderComponent(unref(Link), {
									key: o.id,
									href: o.editUrl,
									class: "block"
								}, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(ssrRenderComponent(_sfc_main$14, { item: o }, null, _parent, _scopeId));
										else return [createVNode(_sfc_main$14, { item: o }, null, 8, ["item"])];
									}),
									_: 2
								}, _parent, _scopeId));
							});
							_push(`<!--]--></div>`);
						} else _push(ssrRenderComponent(_sfc_main$85, {
							title: "Još nema objava",
							text: "Kreirajte prvu objavu i pošaljite je na odobrenje."
						}, null, _parent, _scopeId));
						_push(`</div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [createVNode("div", { class: "flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" }, [createVNode("div", null, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, "Moje objave"), createVNode("p", { class: "mt-1 text-[15px] text-text-muted" }, "Vaše biznis objave i njihov status.")]), createVNode(_sfc_main$93, {
						to: "/nalog/biznis/objave/nova",
						variant: "primary",
						icon: "plus"
					}, {
						default: withCtx(() => [createTextVNode("Nova objava")]),
						_: 1
					})]), __props.objave.length ? (openBlock(), createBlock("div", {
						key: 0,
						class: "space-y-3"
					}, [(openBlock(true), createBlock(Fragment, null, renderList(__props.objave, (o) => {
						return openBlock(), createBlock(unref(Link), {
							key: o.id,
							href: o.editUrl,
							class: "block"
						}, {
							default: withCtx(() => [createVNode(_sfc_main$14, { item: o }, null, 8, ["item"])]),
							_: 2
						}, 1032, ["href"]);
					}), 128))])) : (openBlock(), createBlock(_sfc_main$85, {
						key: 1,
						title: "Još nema objava",
						text: "Kreirajte prvu objavu i pošaljite je na odobrenje."
					}))])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$10 = _sfc_main$10.setup;
_sfc_main$10.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/BiznisObjave.vue");
	return _sfc_setup$10 ? _sfc_setup$10(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/BiznisOglasForm.vue
var BiznisOglasForm_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$9 });
var _sfc_main$9 = {
	__name: "BiznisOglasForm",
	__ssrInlineRender: true,
	props: {
		oglas: {
			type: Object,
			default: null
		},
		vrste: {
			type: Array,
			default: () => []
		}
	},
	setup(__props) {
		const props = __props;
		const form = useForm({
			naslov: props.oglas?.naslov ?? "",
			category_id: props.oglas?.category_id ?? null,
			izdavac: props.oglas?.izdavac ?? "",
			lokacija: props.oglas?.lokacija ?? "",
			rok: props.oglas?.rok ?? "",
			opis_dug: props.oglas?.opis_dug ?? "",
			action: "nacrt"
		});
		function submit(action) {
			form.action = action;
			if (props.oglas) form.put(`/nalog/biznis/oglasi/${props.oglas.id}`);
			else form.post("/nalog/biznis/oglasi");
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(biznisNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>${ssrInterpolate(__props.oglas ? "Uredi oglas" : "Novi oglas")}</h1><p class="mt-1 text-[15px] text-text-muted"${_scopeId}>Popunite oglas i pošaljite ga na odobrenje.</p></div>`);
						if (unref(form).errors.naslov) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Naslov je obavezan."
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7"${_scopeId}><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).naslov,
							"onUpdate:modelValue": ($event) => unref(form).naslov = $event,
							label: "Naslov",
							error: unref(form).errors.naslov
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$78, {
							modelValue: unref(form).category_id,
							"onUpdate:modelValue": ($event) => unref(form).category_id = $event,
							label: "Vrsta",
							placeholder: "Odaberite vrstu",
							options: __props.vrste
						}, null, _parent, _scopeId));
						_push(`</div><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).izdavac,
							"onUpdate:modelValue": ($event) => unref(form).izdavac = $event,
							label: "Izdavač"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).lokacija,
							"onUpdate:modelValue": ($event) => unref(form).lokacija = $event,
							label: "Lokacija"
						}, null, _parent, _scopeId));
						_push(`</div>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).rok,
							"onUpdate:modelValue": ($event) => unref(form).rok = $event,
							label: "Rok važenja",
							type: "date"
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: unref(form).opis_dug,
							"onUpdate:modelValue": ($event) => unref(form).opis_dug = $event,
							label: "Opis",
							rows: 6
						}, null, _parent, _scopeId));
						_push(`</div><div class="flex flex-wrap justify-end gap-3"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "secondary",
							icon: "save",
							disabled: unref(form).processing,
							onClick: ($event) => submit("nacrt")
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Sačuvaj nacrt `);
								else return [createTextVNode(" Sačuvaj nacrt ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "primary",
							icon: "send",
							disabled: unref(form).processing,
							onClick: ($event) => submit("posalji")
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Pošalji na odobrenje `);
								else return [createTextVNode(" Pošalji na odobrenje ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div></div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [
						createVNode("div", null, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, toDisplayString(__props.oglas ? "Uredi oglas" : "Novi oglas"), 1), createVNode("p", { class: "mt-1 text-[15px] text-text-muted" }, "Popunite oglas i pošaljite ga na odobrenje.")]),
						unref(form).errors.naslov ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "greska",
							title: "Provjerite unesene podatke",
							text: "Naslov je obavezan."
						})) : createCommentVNode("", true),
						createVNode("div", { class: "space-y-6 rounded-md border border-border bg-surface p-6 md:p-7" }, [
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).naslov,
								"onUpdate:modelValue": ($event) => unref(form).naslov = $event,
								label: "Naslov",
								error: unref(form).errors.naslov
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]), createVNode(_sfc_main$78, {
								modelValue: unref(form).category_id,
								"onUpdate:modelValue": ($event) => unref(form).category_id = $event,
								label: "Vrsta",
								placeholder: "Odaberite vrstu",
								options: __props.vrste
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"options"
							])]),
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).izdavac,
								"onUpdate:modelValue": ($event) => unref(form).izdavac = $event,
								label: "Izdavač"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]), createVNode(_sfc_main$68, {
								modelValue: unref(form).lokacija,
								"onUpdate:modelValue": ($event) => unref(form).lokacija = $event,
								label: "Lokacija"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
							createVNode(_sfc_main$68, {
								modelValue: unref(form).rok,
								"onUpdate:modelValue": ($event) => unref(form).rok = $event,
								label: "Rok važenja",
								type: "date"
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode(_sfc_main$67, {
								modelValue: unref(form).opis_dug,
								"onUpdate:modelValue": ($event) => unref(form).opis_dug = $event,
								label: "Opis",
								rows: 6
							}, null, 8, ["modelValue", "onUpdate:modelValue"])
						]),
						createVNode("div", { class: "flex flex-wrap justify-end gap-3" }, [createVNode(_sfc_main$93, {
							variant: "secondary",
							icon: "save",
							disabled: unref(form).processing,
							onClick: ($event) => submit("nacrt")
						}, {
							default: withCtx(() => [createTextVNode(" Sačuvaj nacrt ")]),
							_: 1
						}, 8, ["disabled", "onClick"]), createVNode(_sfc_main$93, {
							variant: "primary",
							icon: "send",
							disabled: unref(form).processing,
							onClick: ($event) => submit("posalji")
						}, {
							default: withCtx(() => [createTextVNode(" Pošalji na odobrenje ")]),
							_: 1
						}, 8, ["disabled", "onClick"])])
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$9 = _sfc_main$9.setup;
_sfc_main$9.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/BiznisOglasForm.vue");
	return _sfc_setup$9 ? _sfc_setup$9(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/BiznisOglasi.vue
var BiznisOglasi_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$8 });
var _sfc_main$8 = {
	__name: "BiznisOglasi",
	__ssrInlineRender: true,
	props: { oglasi: {
		type: Array,
		default: () => []
	} },
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(biznisNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"${_scopeId}><div${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>Oglasi</h1><p class="mt-1 text-[15px] text-text-muted"${_scopeId}>Vaši oglasi i njihov status.</p></div>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							to: "/nalog/biznis/oglasi/novi",
							variant: "primary",
							icon: "plus"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`Novi oglas`);
								else return [createTextVNode("Novi oglas")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div>`);
						if (__props.oglasi.length) {
							_push(`<div class="space-y-3"${_scopeId}><!--[-->`);
							ssrRenderList(__props.oglasi, (o) => {
								_push(ssrRenderComponent(unref(Link), {
									key: o.id,
									href: o.editUrl,
									class: "block"
								}, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(ssrRenderComponent(_sfc_main$14, { item: o }, null, _parent, _scopeId));
										else return [createVNode(_sfc_main$14, { item: o }, null, 8, ["item"])];
									}),
									_: 2
								}, _parent, _scopeId));
							});
							_push(`<!--]--></div>`);
						} else _push(ssrRenderComponent(_sfc_main$85, {
							title: "Još nema oglasa",
							text: "Kreirajte prvi oglas i pošaljite ga na odobrenje."
						}, null, _parent, _scopeId));
						_push(`</div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [createVNode("div", { class: "flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" }, [createVNode("div", null, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, "Oglasi"), createVNode("p", { class: "mt-1 text-[15px] text-text-muted" }, "Vaši oglasi i njihov status.")]), createVNode(_sfc_main$93, {
						to: "/nalog/biznis/oglasi/novi",
						variant: "primary",
						icon: "plus"
					}, {
						default: withCtx(() => [createTextVNode("Novi oglas")]),
						_: 1
					})]), __props.oglasi.length ? (openBlock(), createBlock("div", {
						key: 0,
						class: "space-y-3"
					}, [(openBlock(true), createBlock(Fragment, null, renderList(__props.oglasi, (o) => {
						return openBlock(), createBlock(unref(Link), {
							key: o.id,
							href: o.editUrl,
							class: "block"
						}, {
							default: withCtx(() => [createVNode(_sfc_main$14, { item: o }, null, 8, ["item"])]),
							_: 2
						}, 1032, ["href"]);
					}), 128))])) : (openBlock(), createBlock(_sfc_main$85, {
						key: 1,
						title: "Još nema oglasa",
						text: "Kreirajte prvi oglas i pošaljite ga na odobrenje."
					}))])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$8 = _sfc_main$8.setup;
_sfc_main$8.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/BiznisOglasi.vue");
	return _sfc_setup$8 ? _sfc_setup$8(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/BiznisPostavke.vue
var BiznisPostavke_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$7 });
var _sfc_main$7 = {
	__name: "BiznisPostavke",
	__ssrInlineRender: true,
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(biznisNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) _push(ssrRenderComponent(_sfc_main$16, null, null, _parent, _scopeId));
					else return [createVNode(_sfc_main$16)];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$7 = _sfc_main$7.setup;
_sfc_main$7.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/BiznisPostavke.vue");
	return _sfc_setup$7 ? _sfc_setup$7(props, ctx) : void 0;
};
//#endregion
//#region resources/js/Pages/account/BiznisProfil.vue
var BiznisProfil_exports = /* @__PURE__ */ __exportAll({ default: () => _sfc_main$6 });
var _sfc_main$6 = {
	__name: "BiznisProfil",
	__ssrInlineRender: true,
	props: { profil: {
		type: Object,
		default: () => ({})
	} },
	setup(__props) {
		const props = __props;
		const form = useForm({
			name: props.profil.name ?? "",
			telefon: props.profil.telefon ?? "",
			bio: props.profil.bio ?? "",
			avatar: null
		});
		const preview = computed(() => {
			if (form.avatar) return URL.createObjectURL(form.avatar);
			return props.profil.avatar || "";
		});
		const initials = computed(() => (form.name || "").split(" ").map((p) => p[0]).slice(0, 2).join("").toUpperCase());
		function onAvatar(e) {
			form.avatar = e.target.files[0] ?? null;
		}
		function submit() {
			form.post("/nalog/biznis/profil", { preserveScroll: true });
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(ssrRenderComponent(_sfc_main$18, mergeProps({ items: unref(biznisNav) }, _attrs), {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="space-y-6"${_scopeId}><div${_scopeId}><h1 class="font-heading text-[28px] font-bold text-heading"${_scopeId}>Moj profil</h1><p class="mt-1 text-[15px] text-text-muted"${_scopeId}>Podaci o vašem nalogu. E-mail i lozinku mijenjate u Postavkama.</p></div>`);
						if (_ctx.$page.props.flash?.status) _push(ssrRenderComponent(_sfc_main$86, {
							variant: "uspjeh",
							title: "Sačuvano",
							text: _ctx.$page.props.flash.status
						}, null, _parent, _scopeId));
						else _push(`<!---->`);
						_push(`<div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7"${_scopeId}><div class="flex items-center gap-5"${_scopeId}><span class="size-18 shrink-0 overflow-hidden rounded-full bg-primary-tint"${_scopeId}>`);
						if (preview.value) _push(`<img${ssrRenderAttr("src", preview.value)} alt="" class="size-full object-cover"${_scopeId}>`);
						else _push(`<span class="flex size-full items-center justify-center text-2xl font-bold text-primary"${_scopeId}>${ssrInterpolate(initials.value)}</span>`);
						_push(`</span><label class="cursor-pointer"${_scopeId}><span class="inline-flex items-center rounded-sm border border-border px-3 py-2 text-sm font-semibold text-heading hover:bg-surface-alt"${_scopeId}> Promijeni fotografiju </span><input type="file" accept="image/*" class="hidden"${_scopeId}></label></div><div class="grid gap-5 md:grid-cols-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).name,
							"onUpdate:modelValue": ($event) => unref(form).name = $event,
							label: "Ime i prezime / kontakt osoba",
							error: unref(form).errors.name
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$68, {
							modelValue: unref(form).telefon,
							"onUpdate:modelValue": ($event) => unref(form).telefon = $event,
							label: "Telefon",
							type: "tel"
						}, null, _parent, _scopeId));
						_push(`</div>`);
						_push(ssrRenderComponent(_sfc_main$68, {
							"model-value": __props.profil.email,
							label: "E-mail",
							type: "email",
							disabled: ""
						}, null, _parent, _scopeId));
						_push(ssrRenderComponent(_sfc_main$67, {
							modelValue: unref(form).bio,
							"onUpdate:modelValue": ($event) => unref(form).bio = $event,
							label: "Kratka biografija / o nama",
							rows: 4,
							maxlength: 1e3
						}, null, _parent, _scopeId));
						_push(`<div class="flex justify-end"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$93, {
							variant: "primary",
							icon: "check",
							disabled: unref(form).processing,
							onClick: submit
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(` Sačuvaj profil `);
								else return [createTextVNode(" Sačuvaj profil ")];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`</div></div></div>`);
					} else return [createVNode("div", { class: "space-y-6" }, [
						createVNode("div", null, [createVNode("h1", { class: "font-heading text-[28px] font-bold text-heading" }, "Moj profil"), createVNode("p", { class: "mt-1 text-[15px] text-text-muted" }, "Podaci o vašem nalogu. E-mail i lozinku mijenjate u Postavkama.")]),
						_ctx.$page.props.flash?.status ? (openBlock(), createBlock(_sfc_main$86, {
							key: 0,
							variant: "uspjeh",
							title: "Sačuvano",
							text: _ctx.$page.props.flash.status
						}, null, 8, ["text"])) : createCommentVNode("", true),
						createVNode("div", { class: "space-y-6 rounded-md border border-border bg-surface p-6 md:p-7" }, [
							createVNode("div", { class: "flex items-center gap-5" }, [createVNode("span", { class: "size-18 shrink-0 overflow-hidden rounded-full bg-primary-tint" }, [preview.value ? (openBlock(), createBlock("img", {
								key: 0,
								src: preview.value,
								alt: "",
								class: "size-full object-cover"
							}, null, 8, ["src"])) : (openBlock(), createBlock("span", {
								key: 1,
								class: "flex size-full items-center justify-center text-2xl font-bold text-primary"
							}, toDisplayString(initials.value), 1))]), createVNode("label", { class: "cursor-pointer" }, [createVNode("span", { class: "inline-flex items-center rounded-sm border border-border px-3 py-2 text-sm font-semibold text-heading hover:bg-surface-alt" }, " Promijeni fotografiju "), createVNode("input", {
								type: "file",
								accept: "image/*",
								class: "hidden",
								onChange: onAvatar
							}, null, 32)])]),
							createVNode("div", { class: "grid gap-5 md:grid-cols-2" }, [createVNode(_sfc_main$68, {
								modelValue: unref(form).name,
								"onUpdate:modelValue": ($event) => unref(form).name = $event,
								label: "Ime i prezime / kontakt osoba",
								error: unref(form).errors.name
							}, null, 8, [
								"modelValue",
								"onUpdate:modelValue",
								"error"
							]), createVNode(_sfc_main$68, {
								modelValue: unref(form).telefon,
								"onUpdate:modelValue": ($event) => unref(form).telefon = $event,
								label: "Telefon",
								type: "tel"
							}, null, 8, ["modelValue", "onUpdate:modelValue"])]),
							createVNode(_sfc_main$68, {
								"model-value": __props.profil.email,
								label: "E-mail",
								type: "email",
								disabled: ""
							}, null, 8, ["model-value"]),
							createVNode(_sfc_main$67, {
								modelValue: unref(form).bio,
								"onUpdate:modelValue": ($event) => unref(form).bio = $event,
								label: "Kratka biografija / o nama",
								rows: 4,
								maxlength: 1e3
							}, null, 8, ["modelValue", "onUpdate:modelValue"]),
							createVNode("div", { class: "flex justify-end" }, [createVNode(_sfc_main$93, {
								variant: "primary",
								icon: "check",
								disabled: unref(form).processing,
								onClick: submit
							}, {
								default: withCtx(() => [createTextVNode(" Sačuvaj profil ")]),
								_: 1
							}, 8, ["disabled"])])
						])
					])];
				}),
				_: 1
			}, _parent));
		};
	}
};
var _sfc_setup$6 = _sfc_main$6.setup;
_sfc_main$6.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/account/BiznisProfil.vue");
	return _sfc_setup$6 ? _sfc_setup$6(props, ctx) : void 0;
};
//#endregion
//#region resources/js/components/layout/NavDropdown.vue
var _sfc_main$5 = {
	__name: "NavDropdown",
	__ssrInlineRender: true,
	props: { item: {
		type: Object,
		required: true
	} },
	setup(__props) {
		const open = ref(false);
		let timer;
		function show() {
			clearTimeout(timer);
			open.value = true;
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "relative" }, _attrs))} data-v-9b053f94>`);
			_push(ssrRenderComponent(unref(Link), {
				href: __props.item.to,
				class: "inline-flex items-center gap-1 text-sm font-medium text-text transition-colors hover:text-primary",
				"aria-expanded": open.value,
				onFocus: show
			}, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`${ssrInterpolate(__props.item.label)} `);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "chevron-down",
							size: 14,
							class: "text-text-muted"
						}, null, _parent, _scopeId));
					} else return [createTextVNode(toDisplayString(__props.item.label) + " ", 1), createVNode(_sfc_main$97, {
						name: "chevron-down",
						size: 14,
						class: "text-text-muted"
					})];
				}),
				_: 1
			}, _parent));
			if (open.value) {
				_push(`<div class="absolute left-0 top-full z-50 mt-1 min-w-56 rounded-md border border-border bg-surface p-2 shadow-[var(--shadow-md)]" data-v-9b053f94><!--[-->`);
				ssrRenderList(__props.item.children, (c) => {
					_push(ssrRenderComponent(unref(Link), {
						key: c.to,
						href: c.to,
						class: "block rounded-sm px-3 py-2 text-sm text-text transition-colors hover:bg-primary-tint hover:text-primary-dark"
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(`${ssrInterpolate(c.label)}`);
							else return [createTextVNode(toDisplayString(c.label), 1)];
						}),
						_: 2
					}, _parent));
				});
				_push(`<!--]--></div>`);
			} else _push(`<!---->`);
			_push(`</div>`);
		};
	}
};
var _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/NavDropdown.vue");
	return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
var NavDropdown_default = /*#__PURE__*/ _plugin_vue_export_helper_default(_sfc_main$5, [["__scopeId", "data-v-9b053f94"]]);
//#endregion
//#region resources/js/components/layout/MobileDrawer.vue
var _sfc_main$4 = {
	__name: "MobileDrawer",
	__ssrInlineRender: true,
	props: {
		"modelValue": {
			type: Boolean,
			default: false
		},
		"modelModifiers": {}
	},
	emits: ["update:modelValue"],
	setup(__props) {
		const { mainNav, secondaryNav } = useSite();
		const open = useModel(__props, "modelValue");
		const expanded = ref(null);
		const searchTerm = ref("");
		function close() {
			open.value = false;
		}
		watch(open, (v) => {
			document.body.style.overflow = v ? "hidden" : "";
		});
		return (_ctx, _push, _parent, _attrs) => {
			ssrRenderTeleport(_push, (_push) => {
				if (open.value) {
					_push(`<div class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true" data-v-03556072><div class="absolute inset-0 bg-overlay" data-v-03556072></div><aside class="absolute right-0 top-0 flex h-full w-[88%] max-w-sm flex-col bg-surface shadow-[var(--shadow-lg)]" data-v-03556072><div class="flex h-14 shrink-0 items-center justify-between border-b border-border px-4" data-v-03556072>`);
					_push(ssrRenderComponent(unref(Link), {
						href: "/",
						class: "text-xl font-extrabold text-primary",
						onClick: close
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(` teslić `);
							else return [createTextVNode(" teslić ")];
						}),
						_: 1
					}, _parent));
					_push(`<button type="button" class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt" aria-label="Zatvori meni" data-v-03556072>`);
					_push(ssrRenderComponent(_sfc_main$97, {
						name: "x",
						size: 22
					}, null, _parent));
					_push(`</button></div><div class="shrink-0 px-4 pt-4" data-v-03556072><form class="relative" data-v-03556072>`);
					_push(ssrRenderComponent(_sfc_main$97, {
						name: "search",
						size: 18,
						class: "pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"
					}, null, _parent));
					_push(`<input${ssrRenderAttr("value", searchTerm.value)} type="search" placeholder="Pretraži ponudu, događaje, priče…" class="h-11 w-full rounded-sm bg-surface-alt pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-primary" data-v-03556072></form></div><nav class="flex-1 overflow-y-auto p-2 pt-3" data-v-03556072><!--[-->`);
					ssrRenderList(unref(mainNav), (item) => {
						_push(`<!--[-->`);
						if (item.children) {
							_push(`<div data-v-03556072><button type="button" class="${ssrRenderClass([expanded.value === item.label ? "bg-primary-tint text-primary" : "text-text", "flex w-full items-center justify-between rounded-sm px-3 py-3 text-left text-base font-medium hover:bg-surface-alt"])}"${ssrRenderAttr("aria-expanded", expanded.value === item.label)} data-v-03556072>${ssrInterpolate(item.label)} `);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: "chevron-down",
								size: 18,
								class: ["transition-transform", expanded.value === item.label ? "rotate-180 text-primary" : "text-text-muted"]
							}, null, _parent));
							_push(`</button><div class="mb-1 ml-3 border-l border-border pl-3" style="${ssrRenderStyle(expanded.value === item.label ? null : { display: "none" })}" data-v-03556072><!--[-->`);
							ssrRenderList(item.children, (c) => {
								_push(ssrRenderComponent(unref(Link), {
									key: c.to,
									href: c.to,
									class: "block rounded-sm px-3 py-2 text-sm text-text-muted hover:text-primary",
									onClick: close
								}, {
									default: withCtx((_, _push, _parent, _scopeId) => {
										if (_push) _push(`${ssrInterpolate(c.label)}`);
										else return [createTextVNode(toDisplayString(c.label), 1)];
									}),
									_: 2
								}, _parent));
							});
							_push(`<!--]--></div></div>`);
						} else _push(ssrRenderComponent(unref(Link), {
							href: item.to,
							class: "flex items-center justify-between rounded-sm px-3 py-3 text-base font-medium text-text hover:bg-surface-alt hover:text-primary",
							onClick: close
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`${ssrInterpolate(item.label)} `);
									_push(ssrRenderComponent(_sfc_main$97, {
										name: "chevron-right",
										size: 18,
										class: "text-text-muted"
									}, null, _parent, _scopeId));
								} else return [createTextVNode(toDisplayString(item.label) + " ", 1), createVNode(_sfc_main$97, {
									name: "chevron-right",
									size: 18,
									class: "text-text-muted"
								})];
							}),
							_: 2
						}, _parent));
						_push(`<!--]-->`);
					});
					_push(`<!--]--><div class="my-2 border-t border-border" data-v-03556072></div><!--[-->`);
					ssrRenderList(unref(secondaryNav), (item) => {
						_push(ssrRenderComponent(unref(Link), {
							key: item.to,
							href: item.to,
							class: "flex items-center justify-between rounded-sm px-3 py-3 text-base font-medium text-text hover:bg-surface-alt hover:text-primary",
							onClick: close
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) {
									_push(`${ssrInterpolate(item.label)} `);
									_push(ssrRenderComponent(_sfc_main$97, {
										name: "chevron-right",
										size: 18,
										class: "text-text-muted"
									}, null, _parent, _scopeId));
								} else return [createTextVNode(toDisplayString(item.label) + " ", 1), createVNode(_sfc_main$97, {
									name: "chevron-right",
									size: 18,
									class: "text-text-muted"
								})];
							}),
							_: 2
						}, _parent));
					});
					_push(`<!--]--></nav><div class="shrink-0 space-y-2 border-t border-border p-4" data-v-03556072>`);
					_push(ssrRenderComponent(_sfc_main$93, {
						to: "/prijava",
						variant: "secondary",
						block: "",
						onClick: close
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(`Prijava`);
							else return [createTextVNode("Prijava")];
						}),
						_: 1
					}, _parent));
					_push(ssrRenderComponent(_sfc_main$93, {
						to: "/pridruzi-se",
						variant: "primary",
						block: "",
						onClick: close
					}, {
						default: withCtx((_, _push, _parent, _scopeId) => {
							if (_push) _push(` Pridruži se `);
							else return [createTextVNode(" Pridruži se ")];
						}),
						_: 1
					}, _parent));
					_push(`</div></aside></div>`);
				} else _push(`<!---->`);
			}, "body", false, _parent);
		};
	}
};
var _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/MobileDrawer.vue");
	return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
var MobileDrawer_default = /*#__PURE__*/ _plugin_vue_export_helper_default(_sfc_main$4, [["__scopeId", "data-v-03556072"]]);
//#endregion
//#region resources/js/components/layout/AppHeader.vue
var _sfc_main$3 = {
	__name: "AppHeader",
	__ssrInlineRender: true,
	setup(__props) {
		const scrolled = ref(false);
		const drawerOpen = ref(false);
		const searchOpen = ref(false);
		const searchTerm = ref("");
		const searchInput = ref(null);
		const onScroll = () => scrolled.value = window.scrollY > 8;
		const onKey = (e) => {
			if (e.key === "Escape") searchOpen.value = false;
		};
		onMounted(() => {
			window.addEventListener("scroll", onScroll, { passive: true });
			window.addEventListener("keydown", onKey);
			onScroll();
		});
		onUnmounted(() => {
			window.removeEventListener("scroll", onScroll);
			window.removeEventListener("keydown", onKey);
		});
		watch(searchOpen, async (v) => {
			if (v) {
				await nextTick();
				searchInput.value?.focus();
			}
		});
		function submitSearch() {
			const q = searchTerm.value.trim();
			searchOpen.value = false;
			if (q) router.visit(`/mapa?q=${encodeURIComponent(q)}`);
		}
		const { mainNav, kontakt, postavke } = useSite();
		const page = usePage();
		const authUser = computed(() => page.props.auth?.user);
		const nalogLink = computed(() => authUser.value?.role === "autor" ? "/nalog/autor/price" : "/nalog/biznis/profil");
		function logout() {
			router.post("/logout");
		}
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<header${ssrRenderAttrs(mergeProps({ class: ["sticky top-0 z-40 bg-surface transition-shadow", scrolled.value ? "shadow-[var(--shadow-sm)]" : ""] }, _attrs))} data-v-a885ea73><div class="bg-primary-darker text-primary-tint" data-v-a885ea73>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "flex h-10 items-center justify-between text-[13px]" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="flex items-center gap-5" data-v-a885ea73${_scopeId}><a${ssrRenderAttr("href", `tel:${unref(kontakt).telefon}`)} class="flex items-center gap-1.5 hover:text-white" data-v-a885ea73${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "phone",
							size: 14
						}, null, _parent, _scopeId));
						_push(`<span data-v-a885ea73${_scopeId}>${ssrInterpolate(unref(kontakt).telefon)}</span></a><a${ssrRenderAttr("href", `mailto:${unref(kontakt).email}`)} class="hidden items-center gap-1.5 hover:text-white sm:flex" data-v-a885ea73${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "mail",
							size: 14
						}, null, _parent, _scopeId));
						_push(`<span data-v-a885ea73${_scopeId}>${ssrInterpolate(unref(kontakt).email)}</span></a></div><div class="flex items-center gap-4" data-v-a885ea73${_scopeId}><div class="flex items-center gap-1.5" data-v-a885ea73${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "globe",
							size: 14,
							class: "text-white"
						}, null, _parent, _scopeId));
						_push(`<button type="button" class="font-bold text-white" aria-label="Srpski jezik" data-v-a885ea73${_scopeId}>SR</button><span class="text-primary-tint-2" data-v-a885ea73${_scopeId}>|</span><button type="button" class="hover:text-white" aria-label="English language" data-v-a885ea73${_scopeId}>EN</button></div><div class="hidden items-center gap-3 sm:flex" data-v-a885ea73${_scopeId}><!--[-->`);
						ssrRenderList(unref(postavke).social || [], (s) => {
							_push(`<a${ssrRenderAttr("href", s.href)} target="_blank" rel="noopener"${ssrRenderAttr("aria-label", s.label)} class="hover:text-white" data-v-a885ea73${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: s.name,
								size: 15
							}, null, _parent, _scopeId));
							_push(`</a>`);
						});
						_push(`<!--]--></div><div class="hidden items-center gap-3 lg:flex" data-v-a885ea73${_scopeId}>`);
						if (authUser.value) {
							_push(`<!--[-->`);
							_push(ssrRenderComponent(unref(Link), {
								href: nalogLink.value,
								class: "font-semibold text-white hover:text-primary-tint"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(authUser.value.name)}`);
									else return [createTextVNode(toDisplayString(authUser.value.name), 1)];
								}),
								_: 1
							}, _parent, _scopeId));
							_push(`<button type="button" class="inline-flex items-center rounded-sm bg-secondary px-3 py-1 text-[13px] font-bold text-heading transition-colors hover:bg-secondary-dark" data-v-a885ea73${_scopeId}> Odjava </button><!--]-->`);
						} else {
							_push(`<!--[-->`);
							_push(ssrRenderComponent(unref(Link), {
								href: "/prijava",
								class: "font-semibold text-white hover:text-primary-tint"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Prijava `);
									else return [createTextVNode(" Prijava ")];
								}),
								_: 1
							}, _parent, _scopeId));
							_push(ssrRenderComponent(unref(Link), {
								href: "/pridruzi-se",
								class: "inline-flex items-center rounded-sm bg-secondary px-3 py-1 text-[13px] font-bold text-heading transition-colors hover:bg-secondary-dark"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(` Pridruži se `);
									else return [createTextVNode(" Pridruži se ")];
								}),
								_: 1
							}, _parent, _scopeId));
							_push(`<!--]-->`);
						}
						_push(`</div></div>`);
					} else return [createVNode("div", { class: "flex items-center gap-5" }, [createVNode("a", {
						href: `tel:${unref(kontakt).telefon}`,
						class: "flex items-center gap-1.5 hover:text-white"
					}, [createVNode(_sfc_main$97, {
						name: "phone",
						size: 14
					}), createVNode("span", null, toDisplayString(unref(kontakt).telefon), 1)], 8, ["href"]), createVNode("a", {
						href: `mailto:${unref(kontakt).email}`,
						class: "hidden items-center gap-1.5 hover:text-white sm:flex"
					}, [createVNode(_sfc_main$97, {
						name: "mail",
						size: 14
					}), createVNode("span", null, toDisplayString(unref(kontakt).email), 1)], 8, ["href"])]), createVNode("div", { class: "flex items-center gap-4" }, [
						createVNode("div", { class: "flex items-center gap-1.5" }, [
							createVNode(_sfc_main$97, {
								name: "globe",
								size: 14,
								class: "text-white"
							}),
							createVNode("button", {
								type: "button",
								class: "font-bold text-white",
								"aria-label": "Srpski jezik"
							}, "SR"),
							createVNode("span", { class: "text-primary-tint-2" }, "|"),
							createVNode("button", {
								type: "button",
								class: "hover:text-white",
								"aria-label": "English language"
							}, "EN")
						]),
						createVNode("div", { class: "hidden items-center gap-3 sm:flex" }, [(openBlock(true), createBlock(Fragment, null, renderList(unref(postavke).social || [], (s) => {
							return openBlock(), createBlock("a", {
								key: s.name,
								href: s.href,
								target: "_blank",
								rel: "noopener",
								"aria-label": s.label,
								class: "hover:text-white"
							}, [createVNode(_sfc_main$97, {
								name: s.name,
								size: 15
							}, null, 8, ["name"])], 8, ["href", "aria-label"]);
						}), 128))]),
						createVNode("div", { class: "hidden items-center gap-3 lg:flex" }, [authUser.value ? (openBlock(), createBlock(Fragment, { key: 0 }, [createVNode(unref(Link), {
							href: nalogLink.value,
							class: "font-semibold text-white hover:text-primary-tint"
						}, {
							default: withCtx(() => [createTextVNode(toDisplayString(authUser.value.name), 1)]),
							_: 1
						}, 8, ["href"]), createVNode("button", {
							type: "button",
							class: "inline-flex items-center rounded-sm bg-secondary px-3 py-1 text-[13px] font-bold text-heading transition-colors hover:bg-secondary-dark",
							onClick: logout
						}, " Odjava ")], 64)) : (openBlock(), createBlock(Fragment, { key: 1 }, [createVNode(unref(Link), {
							href: "/prijava",
							class: "font-semibold text-white hover:text-primary-tint"
						}, {
							default: withCtx(() => [createTextVNode(" Prijava ")]),
							_: 1
						}), createVNode(unref(Link), {
							href: "/pridruzi-se",
							class: "inline-flex items-center rounded-sm bg-secondary px-3 py-1 text-[13px] font-bold text-heading transition-colors hover:bg-secondary-dark"
						}, {
							default: withCtx(() => [createTextVNode(" Pridruži se ")]),
							_: 1
						})], 64))])
					])];
				}),
				_: 1
			}, _parent));
			_push(`</div><div class="border-b border-border bg-surface" data-v-a885ea73>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: ["flex items-center gap-6 transition-[height] duration-200", scrolled.value ? "h-14 lg:h-16" : "h-16 lg:h-[72px]"] }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(ssrRenderComponent(unref(Link), {
							href: "/",
							class: "shrink-0 text-xl font-extrabold tracking-tight text-primary lg:text-2xl",
							"aria-label": `Početna — ${unref(postavke).brandLogoTekst}`
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`${ssrInterpolate(unref(postavke).brandLogoTekst)}`);
								else return [createTextVNode(toDisplayString(unref(postavke).brandLogoTekst), 1)];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`<nav class="ml-6 hidden items-center gap-x-6 lg:flex" data-v-a885ea73${_scopeId}><!--[-->`);
						ssrRenderList(unref(mainNav), (item) => {
							_push(`<!--[-->`);
							if (item.children) _push(ssrRenderComponent(NavDropdown_default, { item }, null, _parent, _scopeId));
							else _push(ssrRenderComponent(unref(Link), {
								href: item.to,
								class: "text-[15px] font-medium text-text transition-colors hover:text-primary"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(item.label)}`);
									else return [createTextVNode(toDisplayString(item.label), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
							_push(`<!--]-->`);
						});
						_push(`<!--]--></nav><div class="ml-auto flex items-center gap-2" data-v-a885ea73${_scopeId}><button type="button" class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt" aria-label="Pretraga" data-v-a885ea73${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "search",
							size: 20
						}, null, _parent, _scopeId));
						_push(`</button><button type="button" class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt lg:hidden" aria-label="Otvori meni" data-v-a885ea73${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "menu",
							size: 22
						}, null, _parent, _scopeId));
						_push(`</button></div>`);
					} else return [
						createVNode(unref(Link), {
							href: "/",
							class: "shrink-0 text-xl font-extrabold tracking-tight text-primary lg:text-2xl",
							"aria-label": `Početna — ${unref(postavke).brandLogoTekst}`
						}, {
							default: withCtx(() => [createTextVNode(toDisplayString(unref(postavke).brandLogoTekst), 1)]),
							_: 1
						}, 8, ["aria-label"]),
						createVNode("nav", { class: "ml-6 hidden items-center gap-x-6 lg:flex" }, [(openBlock(true), createBlock(Fragment, null, renderList(unref(mainNav), (item) => {
							return openBlock(), createBlock(Fragment, { key: item.to }, [item.children ? (openBlock(), createBlock(NavDropdown_default, {
								key: 0,
								item
							}, null, 8, ["item"])) : (openBlock(), createBlock(unref(Link), {
								key: 1,
								href: item.to,
								class: "text-[15px] font-medium text-text transition-colors hover:text-primary"
							}, {
								default: withCtx(() => [createTextVNode(toDisplayString(item.label), 1)]),
								_: 2
							}, 1032, ["href"]))], 64);
						}), 128))]),
						createVNode("div", { class: "ml-auto flex items-center gap-2" }, [createVNode("button", {
							type: "button",
							class: "inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt",
							"aria-label": "Pretraga",
							onClick: ($event) => searchOpen.value = !searchOpen.value
						}, [createVNode(_sfc_main$97, {
							name: "search",
							size: 20
						})], 8, ["onClick"]), createVNode("button", {
							type: "button",
							class: "inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt lg:hidden",
							"aria-label": "Otvori meni",
							onClick: ($event) => drawerOpen.value = true
						}, [createVNode(_sfc_main$97, {
							name: "menu",
							size: 22
						})], 8, ["onClick"])])
					];
				}),
				_: 1
			}, _parent));
			_push(`</div>`);
			if (searchOpen.value) {
				_push(`<div class="border-t border-border bg-surface" data-v-a885ea73>`);
				_push(ssrRenderComponent(_sfc_main$98, { class: "py-3" }, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) {
							_push(`<form class="flex items-center gap-2" data-v-a885ea73${_scopeId}><div class="relative flex-1" data-v-a885ea73${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: "search",
								size: 18,
								class: "pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"
							}, null, _parent, _scopeId));
							_push(`<input${ssrRenderAttr("value", searchTerm.value)} type="search" placeholder="Pretraži ponudu, lokalitete, događaje…" class="h-11 w-full rounded-sm border border-border bg-surface pl-10 pr-4 outline-none focus:border-primary" data-v-a885ea73${_scopeId}></div>`);
							_push(ssrRenderComponent(_sfc_main$93, {
								type: "submit",
								variant: "primary"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`Traži`);
									else return [createTextVNode("Traži")];
								}),
								_: 1
							}, _parent, _scopeId));
							_push(`</form>`);
						} else return [createVNode("form", {
							class: "flex items-center gap-2",
							onSubmit: withModifiers(submitSearch, ["prevent"])
						}, [createVNode("div", { class: "relative flex-1" }, [createVNode(_sfc_main$97, {
							name: "search",
							size: 18,
							class: "pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-text-muted"
						}), withDirectives(createVNode("input", {
							ref_key: "searchInput",
							ref: searchInput,
							"onUpdate:modelValue": ($event) => searchTerm.value = $event,
							type: "search",
							placeholder: "Pretraži ponudu, lokalitete, događaje…",
							class: "h-11 w-full rounded-sm border border-border bg-surface pl-10 pr-4 outline-none focus:border-primary"
						}, null, 8, ["onUpdate:modelValue"]), [[vModelText, searchTerm.value]])]), createVNode(_sfc_main$93, {
							type: "submit",
							variant: "primary"
						}, {
							default: withCtx(() => [createTextVNode("Traži")]),
							_: 1
						})], 32)];
					}),
					_: 1
				}, _parent));
				_push(`</div>`);
			} else _push(`<!---->`);
			_push(ssrRenderComponent(MobileDrawer_default, {
				modelValue: drawerOpen.value,
				"onUpdate:modelValue": ($event) => drawerOpen.value = $event
			}, null, _parent));
			_push(`</header>`);
		};
	}
};
var _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/AppHeader.vue");
	return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
var AppHeader_default = /*#__PURE__*/ _plugin_vue_export_helper_default(_sfc_main$3, [["__scopeId", "data-v-a885ea73"]]);
//#endregion
//#region resources/js/components/layout/AppFooter.vue
var _sfc_main$2 = {
	__name: "AppFooter",
	__ssrInlineRender: true,
	setup(__props) {
		const { footerLinks, kontakt, postavke } = useSite();
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<footer${ssrRenderAttrs(mergeProps({ class: "mt-16 border-t border-border bg-surface md:mt-24" }, _attrs))}>`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "py-10 md:py-12" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<div class="grid gap-8 md:gap-10 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]"${_scopeId}><div class="max-w-sm"${_scopeId}>`);
						_push(ssrRenderComponent(unref(Link), {
							href: "/",
							class: "text-2xl font-extrabold tracking-tight text-primary"
						}, {
							default: withCtx((_, _push, _parent, _scopeId) => {
								if (_push) _push(`${ssrInterpolate(unref(postavke).brandLogoTekst)}`);
								else return [createTextVNode(toDisplayString(unref(postavke).brandLogoTekst), 1)];
							}),
							_: 1
						}, _parent, _scopeId));
						_push(`<p class="mt-3 text-sm leading-relaxed text-text-muted"${_scopeId}>${ssrInterpolate(unref(postavke).footerOpis)}</p><div class="mt-4 flex gap-2"${_scopeId}><!--[-->`);
						ssrRenderList(unref(postavke).social || [], (s) => {
							_push(`<a${ssrRenderAttr("href", s.href)}${ssrRenderAttr("aria-label", s.label)} class="inline-flex size-9 items-center justify-center rounded-full bg-surface-alt text-primary transition-colors hover:bg-primary-tint"${_scopeId}>`);
							_push(ssrRenderComponent(_sfc_main$97, {
								name: s.name,
								size: 18
							}, null, _parent, _scopeId));
							_push(`</a>`);
						});
						_push(`<!--]--></div></div><div class="grid grid-cols-2 gap-8 md:contents"${_scopeId}><div${_scopeId}><h3 class="text-[13px] font-bold uppercase tracking-wider text-text-muted"${_scopeId}> Brzi linkovi </h3><ul class="mt-3 space-y-3"${_scopeId}><!--[-->`);
						ssrRenderList(unref(footerLinks).brzi, (l) => {
							_push(`<li${_scopeId}>`);
							_push(ssrRenderComponent(unref(Link), {
								href: l.to,
								class: "text-sm text-text transition-colors hover:text-primary"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(l.label)}`);
									else return [createTextVNode(toDisplayString(l.label), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
							_push(`</li>`);
						});
						_push(`<!--]--></ul></div><div${_scopeId}><h3 class="text-[13px] font-bold uppercase tracking-wider text-text-muted"${_scopeId}>Istraži</h3><ul class="mt-3 space-y-3"${_scopeId}><!--[-->`);
						ssrRenderList(unref(footerLinks).istrazi, (l) => {
							_push(`<li${_scopeId}>`);
							_push(ssrRenderComponent(unref(Link), {
								href: l.to,
								class: "text-sm text-text transition-colors hover:text-primary"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(l.label)}`);
									else return [createTextVNode(toDisplayString(l.label), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
							_push(`</li>`);
						});
						_push(`<!--]--></ul></div></div><div${_scopeId}><h3 class="text-[13px] font-bold uppercase tracking-wider text-text-muted"${_scopeId}>Kontakt</h3><ul class="mt-3 space-y-3 text-sm text-text"${_scopeId}><li class="flex items-start gap-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "map-pin",
							size: 16,
							class: "mt-0.5 shrink-0 text-primary"
						}, null, _parent, _scopeId));
						_push(`<span${_scopeId}>${ssrInterpolate(unref(kontakt).adresa)}</span></li><li class="flex items-start gap-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "phone",
							size: 16,
							class: "mt-0.5 shrink-0 text-primary"
						}, null, _parent, _scopeId));
						_push(`<a${ssrRenderAttr("href", `tel:${unref(kontakt).telefon}`)} class="hover:text-primary"${_scopeId}>${ssrInterpolate(unref(kontakt).telefon)}</a></li><li class="flex items-start gap-2"${_scopeId}>`);
						_push(ssrRenderComponent(_sfc_main$97, {
							name: "mail",
							size: 16,
							class: "mt-0.5 shrink-0 text-primary"
						}, null, _parent, _scopeId));
						_push(`<a${ssrRenderAttr("href", `mailto:${unref(kontakt).email}`)} class="break-all hover:text-primary"${_scopeId}>${ssrInterpolate(unref(kontakt).email)}</a></li></ul></div></div>`);
					} else return [createVNode("div", { class: "grid gap-8 md:gap-10 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]" }, [
						createVNode("div", { class: "max-w-sm" }, [
							createVNode(unref(Link), {
								href: "/",
								class: "text-2xl font-extrabold tracking-tight text-primary"
							}, {
								default: withCtx(() => [createTextVNode(toDisplayString(unref(postavke).brandLogoTekst), 1)]),
								_: 1
							}),
							createVNode("p", { class: "mt-3 text-sm leading-relaxed text-text-muted" }, toDisplayString(unref(postavke).footerOpis), 1),
							createVNode("div", { class: "mt-4 flex gap-2" }, [(openBlock(true), createBlock(Fragment, null, renderList(unref(postavke).social || [], (s) => {
								return openBlock(), createBlock("a", {
									key: s.name,
									href: s.href,
									"aria-label": s.label,
									class: "inline-flex size-9 items-center justify-center rounded-full bg-surface-alt text-primary transition-colors hover:bg-primary-tint"
								}, [createVNode(_sfc_main$97, {
									name: s.name,
									size: 18
								}, null, 8, ["name"])], 8, ["href", "aria-label"]);
							}), 128))])
						]),
						createVNode("div", { class: "grid grid-cols-2 gap-8 md:contents" }, [createVNode("div", null, [createVNode("h3", { class: "text-[13px] font-bold uppercase tracking-wider text-text-muted" }, " Brzi linkovi "), createVNode("ul", { class: "mt-3 space-y-3" }, [(openBlock(true), createBlock(Fragment, null, renderList(unref(footerLinks).brzi, (l) => {
							return openBlock(), createBlock("li", { key: l.to }, [createVNode(unref(Link), {
								href: l.to,
								class: "text-sm text-text transition-colors hover:text-primary"
							}, {
								default: withCtx(() => [createTextVNode(toDisplayString(l.label), 1)]),
								_: 2
							}, 1032, ["href"])]);
						}), 128))])]), createVNode("div", null, [createVNode("h3", { class: "text-[13px] font-bold uppercase tracking-wider text-text-muted" }, "Istraži"), createVNode("ul", { class: "mt-3 space-y-3" }, [(openBlock(true), createBlock(Fragment, null, renderList(unref(footerLinks).istrazi, (l) => {
							return openBlock(), createBlock("li", { key: l.to }, [createVNode(unref(Link), {
								href: l.to,
								class: "text-sm text-text transition-colors hover:text-primary"
							}, {
								default: withCtx(() => [createTextVNode(toDisplayString(l.label), 1)]),
								_: 2
							}, 1032, ["href"])]);
						}), 128))])])]),
						createVNode("div", null, [createVNode("h3", { class: "text-[13px] font-bold uppercase tracking-wider text-text-muted" }, "Kontakt"), createVNode("ul", { class: "mt-3 space-y-3 text-sm text-text" }, [
							createVNode("li", { class: "flex items-start gap-2" }, [createVNode(_sfc_main$97, {
								name: "map-pin",
								size: 16,
								class: "mt-0.5 shrink-0 text-primary"
							}), createVNode("span", null, toDisplayString(unref(kontakt).adresa), 1)]),
							createVNode("li", { class: "flex items-start gap-2" }, [createVNode(_sfc_main$97, {
								name: "phone",
								size: 16,
								class: "mt-0.5 shrink-0 text-primary"
							}), createVNode("a", {
								href: `tel:${unref(kontakt).telefon}`,
								class: "hover:text-primary"
							}, toDisplayString(unref(kontakt).telefon), 9, ["href"])]),
							createVNode("li", { class: "flex items-start gap-2" }, [createVNode(_sfc_main$97, {
								name: "mail",
								size: 16,
								class: "mt-0.5 shrink-0 text-primary"
							}), createVNode("a", {
								href: `mailto:${unref(kontakt).email}`,
								class: "break-all hover:text-primary"
							}, toDisplayString(unref(kontakt).email), 9, ["href"])])
						])])
					])];
				}),
				_: 1
			}, _parent));
			_push(`<div class="bg-surface-alt">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "py-7" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<h3 class="text-xs font-bold uppercase tracking-wider text-text-muted"${_scopeId}>Partneri projekta</h3><div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:flex lg:flex-wrap"${_scopeId}><!--[-->`);
						ssrRenderList(unref(postavke).partneri || [], (p) => {
							_push(`<div class="flex h-12 items-center justify-center rounded-sm border border-border bg-surface text-xs text-text-muted lg:w-36"${_scopeId}>${ssrInterpolate(p)}</div>`);
						});
						_push(`<!--]--></div>`);
					} else return [createVNode("h3", { class: "text-xs font-bold uppercase tracking-wider text-text-muted" }, "Partneri projekta"), createVNode("div", { class: "mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:flex lg:flex-wrap" }, [(openBlock(true), createBlock(Fragment, null, renderList(unref(postavke).partneri || [], (p) => {
						return openBlock(), createBlock("div", {
							key: p,
							class: "flex h-12 items-center justify-center rounded-sm border border-border bg-surface text-xs text-text-muted lg:w-36"
						}, toDisplayString(p), 1);
					}), 128))])];
				}),
				_: 1
			}, _parent));
			_push(`</div><div class="bg-primary-darker">`);
			_push(ssrRenderComponent(_sfc_main$98, { class: "flex flex-col gap-2 py-4 text-[13px] text-primary-tint sm:flex-row sm:items-center sm:justify-between" }, {
				default: withCtx((_, _push, _parent, _scopeId) => {
					if (_push) {
						_push(`<p${_scopeId}>${ssrInterpolate(unref(postavke).copyright)}</p><nav class="flex flex-wrap gap-x-4 gap-y-1"${_scopeId}><!--[-->`);
						ssrRenderList(unref(footerLinks).pravno, (l) => {
							_push(ssrRenderComponent(unref(Link), {
								key: l.to,
								href: l.to,
								class: "hover:text-white"
							}, {
								default: withCtx((_, _push, _parent, _scopeId) => {
									if (_push) _push(`${ssrInterpolate(l.label)}`);
									else return [createTextVNode(toDisplayString(l.label), 1)];
								}),
								_: 2
							}, _parent, _scopeId));
						});
						_push(`<!--]--></nav>`);
					} else return [createVNode("p", null, toDisplayString(unref(postavke).copyright), 1), createVNode("nav", { class: "flex flex-wrap gap-x-4 gap-y-1" }, [(openBlock(true), createBlock(Fragment, null, renderList(unref(footerLinks).pravno, (l) => {
						return openBlock(), createBlock(unref(Link), {
							key: l.to,
							href: l.to,
							class: "hover:text-white"
						}, {
							default: withCtx(() => [createTextVNode(toDisplayString(l.label), 1)]),
							_: 2
						}, 1032, ["href"]);
					}), 128))])];
				}),
				_: 1
			}, _parent));
			_push(`</div></footer>`);
		};
	}
};
var _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/AppFooter.vue");
	return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
//#endregion
//#region resources/js/stores/consent.js
var STORAGE_KEY = "to-teslic-cookie-consent";
var hasStorage = () => typeof localStorage !== "undefined";
var useConsentStore = defineStore("consent", () => {
	const accepted = ref(hasStorage() && localStorage.getItem(STORAGE_KEY) === "true");
	function accept() {
		accepted.value = true;
		if (hasStorage()) localStorage.setItem(STORAGE_KEY, "true");
	}
	return {
		accepted,
		accept
	};
});
//#endregion
//#region resources/js/components/layout/CookieBanner.vue
var _sfc_main$1 = {
	__name: "CookieBanner",
	__ssrInlineRender: true,
	setup(__props) {
		const consent = useConsentStore();
		return (_ctx, _push, _parent, _attrs) => {
			if (!unref(consent).accepted) {
				_push(`<div${ssrRenderAttrs(mergeProps({
					class: "fixed inset-x-0 bottom-0 z-50 p-3 md:p-4",
					role: "region",
					"aria-label": "Saglasnost za kolačiće"
				}, _attrs))} data-v-a11efdfe><div class="mx-auto flex max-w-3xl flex-col items-center gap-3 rounded-md border border-border bg-surface px-5 py-4 shadow-[var(--shadow-lg)] sm:flex-row" data-v-a11efdfe><p class="text-sm leading-snug text-text" data-v-a11efdfe> Koristimo kolačiće kako bismo poboljšali vaše iskustvo. Nastavkom pregleda prihvatate politiku kolačića. </p><div class="flex shrink-0 items-center gap-2" data-v-a11efdfe>`);
				_push(ssrRenderComponent(unref(Link), {
					href: "/politika-kolacica",
					class: "px-2 text-sm font-semibold text-primary hover:underline"
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(` Saznaj više `);
						else return [createTextVNode(" Saznaj više ")];
					}),
					_: 1
				}, _parent));
				_push(ssrRenderComponent(_sfc_main$93, {
					variant: "primary",
					size: "sm",
					onClick: unref(consent).accept
				}, {
					default: withCtx((_, _push, _parent, _scopeId) => {
						if (_push) _push(`Prihvati`);
						else return [createTextVNode("Prihvati")];
					}),
					_: 1
				}, _parent));
				_push(`</div></div></div>`);
			} else _push(`<!---->`);
		};
	}
};
var _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/layout/CookieBanner.vue");
	return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
var CookieBanner_default = /*#__PURE__*/ _plugin_vue_export_helper_default(_sfc_main$1, [["__scopeId", "data-v-a11efdfe"]]);
//#endregion
//#region resources/js/Layouts/PublicLayout.vue
var _sfc_main = {
	__name: "PublicLayout",
	__ssrInlineRender: true,
	setup(__props) {
		return (_ctx, _push, _parent, _attrs) => {
			_push(`<div${ssrRenderAttrs(mergeProps({ class: "flex min-h-screen flex-col bg-surface" }, _attrs))}>`);
			_push(ssrRenderComponent(AppHeader_default, null, null, _parent));
			_push(`<main class="flex-1">`);
			ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
			_push(`</main>`);
			_push(ssrRenderComponent(_sfc_main$2, null, null, _parent));
			_push(ssrRenderComponent(CookieBanner_default, null, null, _parent));
			_push(`</div>`);
		};
	}
};
var _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
	const ssrContext = useSSRContext();
	(ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/PublicLayout.vue");
	return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
//#endregion
//#region resources/js/ssr.js
var appName = process.env.VITE_APP_NAME || "TO Teslić";
createServer((page) => createInertiaApp({
	page,
	render: renderToString,
	title: (title) => title ? `${title} — ${appName}` : appName,
	resolve: (name) => {
		const resolved = (/* @__PURE__ */ Object.assign({
			"./Pages/About.vue": About_exports,
			"./Pages/AdDetail.vue": AdDetail_exports,
			"./Pages/AdsListing.vue": AdsListing_exports,
			"./Pages/BusinessProfile.vue": BusinessProfile_exports,
			"./Pages/Contact.vue": Contact_exports,
			"./Pages/Dev.vue": Dev_exports,
			"./Pages/EventDetail.vue": EventDetail_exports,
			"./Pages/Events.vue": Events_exports,
			"./Pages/ForgotPassword.vue": ForgotPassword_exports,
			"./Pages/Home.vue": Home_exports,
			"./Pages/JoinHub.vue": JoinHub_exports,
			"./Pages/Legal.vue": Legal_exports,
			"./Pages/LocalListing.vue": LocalListing_exports,
			"./Pages/LocationDetail.vue": LocationDetail_exports,
			"./Pages/Login.vue": Login_exports,
			"./Pages/Map.vue": Map_exports,
			"./Pages/NotFound.vue": NotFound_exports,
			"./Pages/PageRenderer.vue": PageRenderer_exports,
			"./Pages/RegisterAuthor.vue": RegisterAuthor_exports,
			"./Pages/RegisterBusiness.vue": RegisterBusiness_exports,
			"./Pages/RegisterChoice.vue": RegisterChoice_exports,
			"./Pages/StoriesListing.vue": StoriesListing_exports,
			"./Pages/StoryDetail.vue": StoryDetail_exports,
			"./Pages/TourismListing.vue": TourismListing_exports,
			"./Pages/Welcome.vue": Welcome_exports,
			"./Pages/account/AutorNovaPrica.vue": AutorNovaPrica_exports,
			"./Pages/account/AutorPostavke.vue": AutorPostavke_exports,
			"./Pages/account/AutorPrice.vue": AutorPrice_exports,
			"./Pages/account/AutorProfil.vue": AutorProfil_exports,
			"./Pages/account/BiznisObjavaForm.vue": BiznisObjavaForm_exports,
			"./Pages/account/BiznisObjave.vue": BiznisObjave_exports,
			"./Pages/account/BiznisOglasForm.vue": BiznisOglasForm_exports,
			"./Pages/account/BiznisOglasi.vue": BiznisOglasi_exports,
			"./Pages/account/BiznisPostavke.vue": BiznisPostavke_exports,
			"./Pages/account/BiznisProfil.vue": BiznisProfil_exports
		}))[`./Pages/${name}.vue`];
		if (resolved.default.layout === void 0 && !name.startsWith("account/")) resolved.default.layout = _sfc_main;
		return resolved;
	},
	setup({ App, props, plugin }) {
		return createSSRApp({ render: () => h(App, props) }).use(plugin).use(createPinia());
	}
}));
//#endregion
export {};
