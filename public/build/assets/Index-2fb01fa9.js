import{k as I,K as N,l as B,O as D,m as U,f as l,a as p,u as m,w as _,F as h,p as F,o as t,Z as A,b as s,c as u,d as E,t as c,g as i,j as g,q as w,s as T,v}from"./app-c2754de5.js";import{_ as q}from"./AuthenticatedLayout-fae700c5.js";import{_ as K}from"./Breadcrumb-cd5e7e83.js";import{a as L}from"./TextInput-05cac8ef.js";import{_ as M}from"./PrimaryButton-9e8af232.js";import{_ as R}from"./SelectInput-882fe2d9.js";import{_ as Z}from"./DangerButton-20d0504c.js";import{_ as z,a as G,r as H}from"./Pagination-8756d78a.js";import J from"./Create-1d0548a9.js";import Q from"./Edit-b932f2d9.js";import W from"./Delete-47dc8fa4.js";import{_ as X}from"./Checkbox-f5e88407.js";import{_ as Y,r as ee}from"./InfoButton-38bf06a5.js";import{n as x,f as S}from"./global-16c20635.js";import"./index-67172e5c.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./InputError-f0dfe909.js";import"./SecondaryButton-2a5bdb7b.js";import"./vue-select-bb897b0b.js";import"./vue-datepicker-25a82099.js";/* empty css             */const te={class:"space-y-4"},se={class:"px-4 sm:px-0"},re={class:"rounded-lg overflow-hidden w-fit"},oe={class:"relative bg-white dark:bg-gray-800 shadow sm:rounded-lg"},ae={class:"flex justify-between p-2"},ne={class:"flex space-x-2"},le={class:"overflow-x-auto scrollbar-table"},de={key:0,class:"w-full"},ie={class:"uppercase text-sm border-t border-gray-200 dark:border-gray-700"},ce={class:"dark:bg-gray-900/50 text-left"},pe={class:"px-2 py-4 text-center"},me={key:0,class:"px-2 py-4"},ue=s("th",{class:"px-2 py-4 text-center"},"#",-1),fe=["onClick"],be={class:"flex justify-between items-center"},ye={class:"whitespace-nowrap py-4 px-2 sm:py-3 text-center"},_e=["value"],he={key:0,class:"whitespace-nowrap py-4 w-12 px-2 sm:py-3"},ke={class:"flex justify-center items-center"},ge={class:"rounded-md overflow-hidden"},we={class:"whitespace-nowrap py-4 px-2 sm:py-3 text-center"},ve={class:"whitespace-nowrap py-4 px-2 sm:py-3"},xe={key:0},Se={key:1},$e={key:2},Pe={key:3},Ce={key:4},Oe={key:5},je={class:"border-t border-gray-600"},Ve={key:0,class:"whitespace-nowrap py-4 w-12 px-2 sm:py-3 text-center"},Ie=s("td",{class:"whitespace-nowrap py-4 px-2 sm:py-3 text-center"}," Total: ",-1),Ne={class:"whitespace-nowrap py-4 px-2 sm:py-3 text-center"},Be={key:1,class:"text-center text-xl my-8"},De={key:0,class:"flex justify-between items-center p-2 border-t border-gray-200 dark:border-gray-700"},st={__name:"Index",props:{fromController:Object,total:Number,filters:Object,breadcrumbs:Object,perPage:Number,title:String,numberPermissions:Number,Flash:String},setup(f){const o=f,{_:$,debounce:P,pickBy:C}=F,e=I({params:{search:o.filters.search,field:o.filters.field,order:o.filters.order,perPage:o.perPage},generico:null,selectedId:[],multipleSelect:!1,createOpen:!1,editOpen:!1,deleteOpen:!1,dataSet:N().props.app.perpage}),O=a=>{e.params.field=a,e.params.order=e.params.order==="asc"?"desc":"asc"};B(()=>$.cloneDeep(e.params),P(()=>{let a=C(e.params);D.get(route("ordentrabajo.index"),a,{replace:!0,preserveState:!0,preserveScroll:!0})},150));const j=a=>{var n;a.target.checked===!1?e.selectedId=[]:(n=o.ordentrabajos)==null||n.data.forEach(y=>{e.selectedId.push(y.id)})},V=()=>{var a;((a=o.ordentrabajos)==null?void 0:a.data.length)==e.selectedId.length?e.multipleSelect=!0:e.multipleSelect=!1},b=[{order:"nombre",label:"nombre",type:"text"}];return(a,n)=>{const y=U("tooltip");return t(),l(h,null,[p(m(A),{title:o.title},null,8,["title"]),p(q,null,{default:_(()=>[p(K,{title:f.title,breadcrumbs:f.breadcrumbs},null,8,["title","breadcrumbs"]),s("div",te,[s("div",se,[s("div",re,[a.can(["create ordentrabajo"])?(t(),u(M,{key:0,class:"rounded-none",onClick:n[0]||(n[0]=r=>e.createOpen=!0)},{default:_(()=>[E(c(a.lang().button.add),1)]),_:1})):i("",!0),a.can(["create ordentrabajo"])?(t(),u(J,{key:1,numberPermissions:o.numberPermissions,titulos:b,show:e.createOpen,onClose:n[1]||(n[1]=r=>e.createOpen=!1),title:o.title,losSelect:o.losSelect},null,8,["numberPermissions","show","title","losSelect"])):i("",!0),a.can(["update ordentrabajo"])?(t(),u(Q,{key:2,titulos:b,numberPermissions:o.numberPermissions,show:e.editOpen,onClose:n[2]||(n[2]=r=>e.editOpen=!1),generica:e.generico,title:o.title,losSelect:o.losSelect},null,8,["numberPermissions","show","generica","title","losSelect"])):i("",!0),a.can(["delete ordentrabajo"])?(t(),u(W,{key:3,numberPermissions:o.numberPermissions,show:e.deleteOpen,onClose:n[3]||(n[3]=r=>e.deleteOpen=!1),generica:e.generico,title:o.title},null,8,["numberPermissions","show","generica","title"])):i("",!0)])]),s("div",oe,[s("div",ae,[s("div",ne,[p(R,{modelValue:e.params.perPage,"onUpdate:modelValue":n[4]||(n[4]=r=>e.params.perPage=r),dataSet:e.dataSet},null,8,["modelValue","dataSet"])]),o.numberPermissions>1?(t(),u(L,{key:0,modelValue:e.params.search,"onUpdate:modelValue":n[5]||(n[5]=r=>e.params.search=r),type:"text",class:"block w-4/6 md:w-3/6 lg:w-2/6 rounded-lg",placeholder:"Buscar..."},null,8,["modelValue"])):i("",!0)]),s("div",le,[o.total>0?(t(),l("table",de,[s("thead",ie,[s("tr",ce,[s("th",pe,[p(X,{checked:e.multipleSelect,"onUpdate:checked":n[6]||(n[6]=r=>e.multipleSelect=r),onChange:j},null,8,["checked"])]),f.numberPermissions>1?(t(),l("th",me,"Accion")):i("",!0),ue,(t(),l(h,null,g(b,r=>s("th",{class:"px-2 py-4 cursor-pointer",onClick:k=>O(r.order)},[s("div",be,[s("span",null,c(a.lang().label[r.label]),1),p(m(G),{class:"w-4 h-4"})])],8,fe)),64))])]),s("tbody",null,[(t(!0),l(h,null,g(o.fromController.data,(r,k)=>(t(),l("tr",{key:k,class:"border-t border-gray-200 dark:border-gray-700 hover:bg-gray-200/30 hover:dark:bg-gray-900/20"},[s("td",ye,[w(s("input",{class:"rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-primary dark:text-primary shadow-sm focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-gray-800 dark:checked:bg-primary dark:checked:border-primary",type:"checkbox",onChange:V,value:r.id,"onUpdate:modelValue":n[7]||(n[7]=d=>e.selectedId=d)},null,40,_e),[[T,e.selectedId]])]),f.numberPermissions>1?(t(),l("td",he,[s("div",ke,[s("div",ge,[w((t(),u(Y,{type:"button",onClick:d=>(e.editOpen=!0,e.generico=r),class:"px-2 py-1.5 rounded-none"},{default:_(()=>[p(m(ee),{class:"w-4 h-4"})]),_:2},1032,["onClick"])),[[v,a.can(["update user"])],[y,a.lang().tooltip.edit]]),w((t(),u(Z,{type:"button",onClick:d=>(e.deleteOpen=!0,e.generico=r),class:"px-2 py-1.5 rounded-none"},{default:_(()=>[p(m(H),{class:"w-4 h-4"})]),_:2},1032,["onClick"])),[[v,a.can(["delete user"])],[y,a.lang().tooltip.delete]])])])])):i("",!0),s("td",we,c(++k),1),(t(),l(h,null,g(b,d=>s("td",ve,[d.type=="text"?(t(),l("span",xe,c(r[d.order]),1)):i("",!0),d.type=="number"?(t(),l("span",Se,c(m(x)(r[d.order],0,!1)),1)):i("",!0),d.type=="dinero"?(t(),l("span",$e,c(m(x)(r[d.order],0,!0)),1)):i("",!0),d.type=="date"?(t(),l("span",Pe,c(m(S)(r[d.order],!1)),1)):i("",!0),d.type=="datetime"?(t(),l("span",Ce,c(m(S)(r[d.order],!0)),1)):i("",!0),d.type=="foreign"?(t(),l("span",Oe,c(r[d.nameid]),1)):i("",!0)])),64))]))),128)),s("tr",je,[f.numberPermissions>1?(t(),l("td",Ve," - ")):i("",!0),Ie,s("td",Ne,c(o.total),1)])])])):(t(),l("h2",Be,"Sin Registros"))]),o.total>0?(t(),l("div",De,[p(z,{links:o.fromController,filters:e.params},null,8,["links","filters"])])):i("",!0)])])]),_:1})],64)}}};export{st as default};
