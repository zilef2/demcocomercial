import{T as f,f as _,a as c,w as m,o as g,b as o,t,d as l,u as i,n as b,e as h}from"./app-c2754de5.js";import{_ as y}from"./DangerButton-20d0504c.js";import{_ as w,a as x}from"./SecondaryButton-2a5bdb7b.js";const k={class:"space-y-6"},S=["onSubmit"],v={class:"text-lg font-medium text-gray-900 dark:text-gray-100"},C={class:"mt-1 text-sm text-gray-600 dark:text-gray-400"},$={class:"mt-6 flex justify-end"},D={__name:"Delete",props:{show:Boolean,title:String,permission:Object},emits:["close"],setup(u,{emit:r}){const n=u,s=f({}),p=()=>{var e;s.delete(route("permission.destroy",(e=n.permission)==null?void 0:e.id),{preserveScroll:!0,onSuccess:()=>{r("close"),s.reset()},onError:()=>null,onFinish:()=>null})};return(e,a)=>(g(),_("section",k,[c(w,{show:n.show,onClose:a[1]||(a[1]=d=>r("close")),maxWidth:"lg"},{default:m(()=>{var d;return[o("form",{class:"p-6",onSubmit:h(p,["prevent"])},[o("h2",v,t(e.lang().label.delete)+" "+t(n.title),1),o("p",C,[l(t(e.lang().label.delete_confirm)+" ",1),o("b",null,t((d=n.permission)==null?void 0:d.name),1),l("? ")]),o("div",$,[c(x,{disabled:i(s).processing,onClick:a[0]||(a[0]=B=>r("close"))},{default:m(()=>[l(t(e.lang().button.close),1)]),_:1},8,["disabled"]),c(y,{class:b(["ml-3",{"opacity-25":i(s).processing}]),disabled:i(s).processing,onClick:p},{default:m(()=>[l(t(i(s).processing?e.lang().button.delete+"...":e.lang().button.delete),1)]),_:1},8,["class","disabled"])])],40,S)]}),_:1},8,["show"])]))}};export{D as default};
