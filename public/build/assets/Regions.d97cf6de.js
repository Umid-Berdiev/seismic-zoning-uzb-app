import{n as A,p as j,b as k,q as $,r as R,o as O,c as r,e as c,f as e,t as a,g as l,i as E,_ as U,l as q,u as n,F as S,x as C,j as B,y as T,z as D,M as G}from"./app.2776a0ac.js";import{u as H}from"./useNotyf.1dad4154.js";import{_ as f}from"./Input.25b72b47.js";import{_ as J}from"./Button.a880e3b5.js";import{_ as b}from"./InputLabel.ea37e2c4.js";import{C as K}from"./ConfirmModal.12b0d823.js";const _=u=>(T("data-v-b6080716"),u=u(),D(),u),P={class:"content"},Q={class:"d-flex justify-content-end"},W={type:"button",class:"btn btn-alt-primary","data-bs-toggle":"modal","data-bs-target":"#modal-confirm"},X=_(()=>e("i",{class:"fa fa-download me-1"},null,-1)),Y=_(()=>e("br",null,null,-1)),Z={key:0,class:"text-center"},ee={key:1,class:"row"},te={class:"col-md-12"},oe={class:"table-responsive"},se={class:"table table-striped mb-0"},ae=_(()=>e("th",{scope:"col"},"#",-1)),ne={scope:"row"},le={class:"d-flex gap-2"},de=["onClick"],ie=_(()=>e("i",{class:"si si-eye"},null,-1)),re=[ie],ce=["onClick"],ue=_(()=>e("i",{class:"si si-pencil"},null,-1)),_e=[ue],me={class:"modal fade",id:"regionFormModal",tabindex:"-1","aria-labelledby":"regionFormModalLabel","aria-hidden":"true"},fe={class:"modal-dialog modal-dialog-popout"},be={class:"modal-content"},pe={class:"modal-header"},he={class:"modal-title",id:"regionFormModalLabel"},ve=_(()=>e("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"},null,-1)),ge={class:"modal-body"},ye=["onSubmit"],ze={class:"row"},Ve={class:"col-12 mb-3"},xe={class:"invalid-feedback animated fadeIn"},ke={class:"col-12 mb-3"},$e={class:"invalid-feedback animated fadeIn"},Ee={class:"col-12 mb-3"},Se={class:"invalid-feedback animated fadeIn"},Ce={class:"col-12 mb-3"},Me={class:"invalid-feedback animated fadeIn"},Fe={class:"col-auto ms-auto"},Ie={__name:"Regions",props:{regions:{type:Array,default:()=>[]}},setup(u){const g=H(),p=j(()=>G.getOrCreateInstance("#regionFormModal")),M=k([{name:"Soato",field:"soato"},{name:"Name uz",field:"name_uz"}]),h=k({name_uz:"",name_ru:"",admincenter_uz:"",admincenter_ru:""}),o=$(h),v=R(!1);O(()=>{var s;(s=p.value)==null||s._element.addEventListener("hidden.bs.modal",m=>{o.reset(),o.clearErrors(),v.value=!1}),document.querySelectorAll("#datasetLength label").forEach(m=>{m.remove()});let t=document.querySelector("#datasetLength select");t&&(t.classList="",t.classList.add("form-select"))});async function F(){o.put(route("regions.update",h.id),{onSuccess:()=>{var t;g.success("Region successfully updated!"),o.reset(),o.clearErrors(),(t=p.value)==null||t.hide()},onError:t=>{g.error("Error while updating region!")}})}function I(t){var s;v.value=!0,Object.assign(h,t),o.name_uz=t.name_uz,o.name_ru=t.name_ru,o.admincenter_uz=t.admincenter_uz,o.admincenter_ru=t.admincenter_ru,(s=p.value)==null||s.toggle()}function L(t){$().get(route("districts.index",t))}function N(){location.href=route("regions.export")}return(t,s)=>{var m,y,z,V;return r(),c("div",P,[e("div",Q,[e("button",W,[X,e("span",null,a(t.$t("Export_to_excel")),1)])]),Y,l(U,{title:t.$t("Regions_table"),"content-full":""},{default:E(()=>{var d;return[((d=u.regions)==null?void 0:d.length)==0?(r(),c("div",Z,a(t.$t("No_data")),1)):(r(),c("div",ee,[e("div",te,[e("div",oe,[e("table",se,[e("thead",null,[e("tr",null,[ae,(r(!0),c(S,null,C(M,(i,x)=>(r(),c("th",{key:i.field},a(i.name),1))),128)),e("th",null,a(t.$t("Actions")),1)])]),e("tbody",null,[(r(!0),c(S,null,C(u.regions,(i,x)=>(r(),c("tr",{key:i.id},[e("th",ne,a(x+1),1),e("td",null,a(i.soato),1),e("td",null,a(i.name_uz),1),e("td",le,[e("button",{type:"button",class:"btn btn-secondary w-auto",onClick:w=>L(i.id)},re,8,de),e("button",{type:"button",class:"btn btn-secondary w-auto",onClick:w=>I(i)},_e,8,ce)])]))),128))])])])])]))]}),_:1},8,["title"]),e("div",me,[e("div",fe,[e("div",be,[e("div",pe,[e("h5",he,a(v.value?t.$t("Edit_region_data"):t.$t("Add_region_data")),1),ve]),e("div",ge,[e("form",{onSubmit:q(F,["prevent"])},[e("div",ze,[e("div",Ve,[l(b,{value:"Name uz"}),l(f,{type:"text",modelValue:n(o).name_uz,"onUpdate:modelValue":s[0]||(s[0]=d=>n(o).name_uz=d)},null,8,["modelValue"]),e("div",xe,a((m=n(o).errors)==null?void 0:m.name_uz),1)]),e("div",ke,[l(b,{value:"Name ru"}),l(f,{type:"text",modelValue:n(o).name_ru,"onUpdate:modelValue":s[1]||(s[1]=d=>n(o).name_ru=d)},null,8,["modelValue"]),e("div",$e,a((y=n(o).errors)==null?void 0:y.name_ru),1)]),e("div",Ee,[l(b,{value:"Admincenter uz"}),l(f,{type:"text",modelValue:n(o).admincenter_uz,"onUpdate:modelValue":s[2]||(s[2]=d=>n(o).admincenter_uz=d)},null,8,["modelValue"]),e("div",Se,a((z=n(o).errors)==null?void 0:z.admincenter_uz),1)]),e("div",Ce,[l(b,{value:"Admincenter ru"}),l(f,{type:"text",modelValue:n(o).admincenter_ru,"onUpdate:modelValue":s[3]||(s[3]=d=>n(o).admincenter_ru=d)},null,8,["modelValue"]),e("div",Me,a((V=n(o).errors)==null?void 0:V.admincenter_ru),1)]),e("div",Fe,[l(J,null,{default:E(()=>[B(a(t.$t("Submit")),1)]),_:1})])])],40,ye)])])])]),l(K,{onConfirm:N})])}}},Oe=A(Ie,[["__scopeId","data-v-b6080716"]]);export{Oe as default};
