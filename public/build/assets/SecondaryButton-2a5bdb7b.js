import{l as p,C as w,M as x,h as g,o as u,c as h,a as l,w as n,q as r,v as c,b as s,B as i,n as v,r as y,g as b,U as k,f as _}from"./app-c2754de5.js";const B={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},C=s("div",{class:"absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"},null,-1),E=[C],N={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!1}},emits:["close"],setup(e,{emit:t}){const a=e;p(()=>a.show,()=>{a.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const d=()=>{a.closeable&&t("close")},m=o=>{o.key==="Escape"&&a.show&&d()};w(()=>document.addEventListener("keydown",m)),x(()=>{document.removeEventListener("keydown",m),document.body.style.overflow=null});const f=g(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"max-w-5xl","3xl":"max-w-6xl","4xl":"max-w-6xl"})[a.maxWidth]);return(o,$)=>(u(),h(k,{to:"body"},[l(i,{"leave-active-class":"duration-400"},{default:n(()=>[r(s("div",B,[l(i,{"enter-active-class":"ease-out duration-200","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:n(()=>[r(s("div",{class:"fixed inset-0 transform transition-all",onClick:d},E,512),[[c,e.show]])]),_:1}),l(i,{"enter-active-class":"ease-out duration-200","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:n(()=>[r(s("div",{class:v(["mb-12 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",f.value])},[e.show?y(o.$slots,"default",{key:0}):b("",!0)],2),[[c,e.show]])]),_:3})],512),[[c,e.show]])]),_:3})]))}},S=["type"],V={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup(e){return(t,a)=>(u(),_("button",{type:e.type,class:"inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"},[y(t.$slots,"default")],8,S))}};export{N as _,V as a};
