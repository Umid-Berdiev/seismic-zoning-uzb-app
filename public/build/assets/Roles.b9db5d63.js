import{_ as F,a as E,u as L,k as R,r as D,o as N,b as f,c as b,e as l,w as p,g as e,t as a,j as V,i as d,C as A,P as j,f as B,F as I,h as O,z as Y,A as U,B as q,M as T}from"./app.56cb7126.js";import{u as z}from"./useNotyf.9adfdd7d.js";import{_ as P}from"./Input.7aced2d7.js";import{_ as G}from"./Button.22fb6a3c.js";import{h as H}from"./helper.cdd34f31.js";import{b as J,w as K}from"./vue-dataset.es.b193e4bb.js";import{_ as Q}from"./BaseBlock.22552c46.js";import{_ as S}from"./InputLabel.5b59311f.js";import{C as W}from"./ConfirmModal.5c5d956d.js";import{_ as M}from"./InputError.fee64527.js";import"./moment.62d3fb0a.js";const g=i=>(U("data-v-196f314c"),i=i(),q(),i),X={class:"content"},Z={key:0,class:"text-center"},ee={class:"row"},se={class:"col-md-12"},te={class:"table-responsive"},oe={class:"table table-striped mb-0"},ae=g(()=>e("th",{scope:"col"},"#",-1)),le={scope:"row"},de={class:"d-flex gap-2"},re=["onClick"],ne=g(()=>e("i",{class:"si si-pencil"},null,-1)),ie=[ne],ce={class:"modal fade",id:"roleFormModal",tabindex:"-1","aria-labelledby":"roleFormModalLabel","aria-hidden":"true"},ue={class:"modal-dialog"},me={class:"modal-content"},_e={class:"modal-header"},fe={class:"modal-title",id:"roleFormModalLabel"},pe=g(()=>e("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"},null,-1)),he={class:"modal-body"},ve=["onSubmit"],be={class:"row"},ge={class:"col-12 mb-3"},ye=g(()=>e("span",{class:"text-danger"},"*",-1)),Ee={class:"col-12 mb-3"},Se={class:"col-auto ms-auto"},Me={__name:"Roles",props:{roles:{type:Array,default:()=>[]}},setup(i){const $=i,c=z(),h=E({name:"",details:""}),t=L(h),_=R(()=>T.getOrCreateInstance("#roleFormModal")),w=E([{name:"Name",field:"name"},{name:"Slug",field:"slug"},{name:"Details",field:"details"},{name:"Updated at",field:"updated_at"}]),u=D(!1);N(()=>{var o;(o=_.value)==null||o._element.addEventListener("hidden.bs.modal",r=>{t.reset(),t.clearErrors(),u.value=!1}),document.querySelectorAll("#datasetLength label").forEach(r=>{r.remove()});let s=document.querySelector("#datasetLength select");s&&(s.classList="",s.classList.add("form-select"))});async function k(){u.value?t.put(route("roles.update",h.id),{onSuccess:()=>{var s;c.success("Role successfully updated!"),(s=_.value)==null||s.hide(),t.reset(),t.clearErrors(),u.value=!1},onError:s=>{c.error("Error while updating role!")}}):t.post(route("roles.store"),{onSuccess:()=>{var s;c.success("Role successfully updated!"),(s=_.value)==null||s.hide(),t.reset(),t.clearErrors(),u.value=!1},onError:s=>{c.error("Error while creating role!")}})}function x(s){var r;u.value=!0;const o=$.roles.find(v=>v.id===s);Object.assign(h,o),t.name=o.name,t.details=o.details,(r=_.value)==null||r.toggle()}function C(){t.delete(route("roles.destroy",h.id),{onSuccess:()=>{var s;c.success("Role successfully removed!"),(s=_.value)==null||s.hide()},onError:s=>{c.error("Error while deleting role!")}})}return(s,o)=>{var r,v;return f(),b("div",X,[l(Q,{title:s.$t("Roles_table"),"content-full":""},{default:p(()=>{var m;return[((m=i.roles)==null?void 0:m.length)==0?(f(),b("div",Z,a(s.$t("No_data")),1)):(f(),B(d(K),{key:1,"ds-data":i.roles},{default:p(()=>[e("div",ee,[e("div",se,[e("div",te,[e("table",oe,[e("thead",null,[e("tr",null,[ae,(f(!0),b(I,null,O(w,(n,y)=>(f(),b("th",{key:n.field},a(n.name),1))),128)),e("th",null,a(s.$t("Actions")),1)])]),l(d(J),{tag:"tbody",class:"fs-sm"},{default:p(({row:n,rowIndex:y})=>[e("tr",null,[e("th",le,a(y+1),1),e("td",null,a(n.name),1),e("td",null,a(n.slug),1),e("td",null,a(n.details),1),e("td",null,a(d(H).formatDate(n.updated_at,"DD-MM-YYYY")),1),e("td",de,[e("button",{type:"button",class:"btn btn-secondary w-auto",onClick:$e=>x(n.id)},ie,8,re)])])]),_:1})])])])])]),_:1},8,["ds-data"]))]}),_:1},8,["title"]),e("div",ce,[e("div",ue,[e("div",me,[e("div",_e,[e("h5",fe,a(u.value?"Edit role data":"Add role data"),1),pe]),e("div",he,[e("form",{onSubmit:V(k,["prevent"])},[e("div",be,[e("div",ge,[l(S,{for:"name-input"},{default:p(()=>[e("span",null,a(s.$t("Name")),1),ye]),_:1}),l(P,{id:"name-input",type:"text",modelValue:d(t).name,"onUpdate:modelValue":o[0]||(o[0]=m=>d(t).name=m)},null,8,["modelValue"]),l(M,{message:(r=d(t).errors)==null?void 0:r.name},null,8,["message"])]),e("div",Ee,[l(S,{for:"details-input",value:"Details"}),A(e("textarea",{id:"details-input",class:"form-control","onUpdate:modelValue":o[1]||(o[1]=m=>d(t).details=m)},null,512),[[j,d(t).details]]),l(M,{message:(v=d(t).errors)==null?void 0:v.details},null,8,["message"])]),e("div",Se,[l(G,null,{default:p(()=>[Y(a(s.$t("Submit")),1)]),_:1})])])],40,ve)])])])]),l(W,{onConfirm:C})])}}},je=F(Me,[["__scopeId","data-v-196f314c"]]);export{je as default};
