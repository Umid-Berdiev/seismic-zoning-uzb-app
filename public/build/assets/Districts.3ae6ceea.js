import{n as I,p as N,b as w,q as S,r as A,o as D,c as _,e as m,f as e,l as $,t as l,g as n,i as p,_ as j,u as a,v as B,F as O,x as U,j as q,y as P,z as T,M as R}from"./app.dfbb29b1.js";import{u as G}from"./useNotyf.e4c647d9.js";import{_ as f}from"./Input.e72bff60.js";import{_ as H}from"./Button.660ab17a.js";import{x as J,P as K,b as Q,_ as W,y as X,w as Y}from"./vue-dataset.es.bcf491c7.js";import{_ as h}from"./InputLabel.1fa045a2.js";import{C as Z}from"./ConfirmModal.c34c49a7.js";const c=r=>(P("data-v-309b20c8"),r=r(),T(),r),ee={class:"content"},te={class:"d-flex"},se=c(()=>e("i",{class:"si si-arrow-left me-1"},null,-1)),ae={type:"button",class:"btn btn-alt-primary ms-auto","data-bs-toggle":"modal","data-bs-target":"#modal-confirm"},oe=c(()=>e("i",{class:"fa fa-download me-1"},null,-1)),ne=c(()=>e("br",null,null,-1)),le={key:0,class:"text-center"},de=["data-page-count"],ie={id:"datasetLength",class:"col-auto py-2"},ce={class:"col-auto ms-auto py-2"},re=c(()=>e("hr",null,null,-1)),ue={class:"row"},_e={class:"col-md-12"},me={class:"table-responsive"},pe={class:"table table-striped mb-0"},fe=c(()=>e("th",{scope:"col"},"#",-1)),he={scope:"row"},be={class:"d-flex gap-2"},ve=["onClick"],ye=c(()=>e("i",{class:"si si-pencil"},null,-1)),ge=[ye],xe={class:"d-flex flex-md-row flex-column justify-content-between align-items-center"},ze={class:"modal fade",id:"districtFormModal",tabindex:"-1","aria-labelledby":"districtFormModalLabel","aria-hidden":"true"},Ve={class:"modal-dialog modal-dialog-popout"},ke={class:"modal-content"},we={class:"modal-header"},Se={class:"modal-title",id:"districtFormModalLabel"},$e=c(()=>e("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"},null,-1)),Ee={class:"modal-body"},Le=["onSubmit"],Me={class:"row"},Ce={class:"col-12 mb-3"},Fe={class:"invalid-feedback animated fadeIn"},Ie={class:"col-12 mb-3"},Ne={class:"invalid-feedback animated fadeIn"},Ae={class:"col-12 mb-3"},De={class:"invalid-feedback animated fadeIn"},je={class:"col-12 mb-3"},Be={class:"invalid-feedback animated fadeIn"},Oe={class:"col-auto ms-auto"},Ue={__name:"Districts",props:{districts:{type:Array,default:()=>[]}},setup(r){const g=G(),b=N(()=>R.getOrCreateInstance("#districtFormModal")),E=w([{name:"Soato",field:"soato"},{name:"Region soato",field:"region_soato"},{name:"Name uz",field:"name_uz"}]),v=w({name_uz:"",name_ru:"",admincenter_uz:"",admincenter_ru:""}),s=S(v),y=A(!1);D(()=>{var o;(o=b.value)==null||o._element.addEventListener("hidden.bs.modal",u=>{s.reset(),s.clearErrors(),y.value=!1}),document.querySelectorAll("#datasetLength label").forEach(u=>{u.remove()});let t=document.querySelector("#datasetLength select");t&&(t.classList="",t.classList.add("form-select"))});async function L(){s.put(route("districts.update",v.id),{onSuccess:()=>{var t;g.success("District successfully updated!"),s.reset(),s.clearErrors(),(t=b.value)==null||t.hide()},onError:t=>{g.error("Error while updating district!")}})}function M(t){var o;y.value=!0,Object.assign(v,t),s.name_uz=t.name_uz,s.name_ru=t.name_ru,s.admincenter_uz=t.admincenter_uz,s.admincenter_ru=t.admincenter_ru,(o=b.value)==null||o.toggle()}function C(){location.href=route("districts.export",route().params.region)}return(t,o)=>{var u,x,z,V;return _(),m("div",ee,[e("div",te,[e("button",{type:"button",class:"btn btn-alt-primary",onClick:o[0]||(o[0]=$(d=>a(S)().get(t.route("regions.index")),["prevent"]))},[se,e("span",null,l(t.$t("Back")),1)]),e("button",ae,[oe,e("span",null,l(t.$t("Export_to_excel")),1)])]),ne,n(j,{title:t.$t("Districts_table"),"content-full":""},{default:p(()=>{var d;return[((d=r.districts)==null?void 0:d.length)==0?(_(),m("div",le,l(t.$t("No_data")),1)):(_(),B(a(Y),{key:1,"ds-data":r.districts},{default:p(F=>[e("div",{class:"row","data-page-count":F.dsPagecount},[e("div",ie,[n(a(J))]),e("div",ce,[n(a(K),{"ds-search-placeholder":t.$t("Search")+"..."},null,8,["ds-search-placeholder"])])],8,de),re,e("div",ue,[e("div",_e,[e("div",me,[e("table",pe,[e("thead",null,[e("tr",null,[fe,(_(!0),m(O,null,U(E,(i,k)=>(_(),m("th",{key:i.field},l(i.name),1))),128)),e("th",null,l(t.$t("Actions")),1)])]),n(a(Q),{tag:"tbody",class:"fs-sm"},{default:p(({row:i,rowIndex:k})=>[e("tr",null,[e("th",he,l(k+1),1),e("td",null,l(i.soato),1),e("td",null,l(i.region_soato),1),e("td",null,l(i.name_uz),1),e("td",be,[e("button",{type:"button",class:"btn btn-secondary w-auto",onClick:qe=>M(i)},ge,8,ve)])])]),_:1})])])])]),e("div",xe,[n(a(W),{class:"py-3 fs-sm"}),n(a(X),{class:"flex-wrap py-3 fs-sm"})])]),_:1},8,["ds-data"]))]}),_:1},8,["title"]),e("div",ze,[e("div",Ve,[e("div",ke,[e("div",we,[e("h5",Se,l(y.value?"Edit district data":"Add district data"),1),$e]),e("div",Ee,[e("form",{onSubmit:$(L,["prevent"])},[e("div",Me,[e("div",Ce,[n(h,{value:"Name uz"}),n(f,{type:"text",modelValue:a(s).name_uz,"onUpdate:modelValue":o[1]||(o[1]=d=>a(s).name_uz=d)},null,8,["modelValue"]),e("div",Fe,l((u=a(s).errors)==null?void 0:u.name_uz),1)]),e("div",Ie,[n(h,{value:"Name ru"}),n(f,{type:"text",modelValue:a(s).name_ru,"onUpdate:modelValue":o[2]||(o[2]=d=>a(s).name_ru=d)},null,8,["modelValue"]),e("div",Ne,l((x=a(s).errors)==null?void 0:x.name_ru),1)]),e("div",Ae,[n(h,{value:"Admincenter uz"}),n(f,{type:"text",modelValue:a(s).admincenter_uz,"onUpdate:modelValue":o[3]||(o[3]=d=>a(s).admincenter_uz=d)},null,8,["modelValue"]),e("div",De,l((z=a(s).errors)==null?void 0:z.admincenter_uz),1)]),e("div",je,[n(h,{value:"Admincenter ru"}),n(f,{type:"text",modelValue:a(s).admincenter_ru,"onUpdate:modelValue":o[4]||(o[4]=d=>a(s).admincenter_ru=d)},null,8,["modelValue"]),e("div",Be,l((V=a(s).errors)==null?void 0:V.admincenter_ru),1)]),e("div",Oe,[n(H,null,{default:p(()=>[q(l(t.$t("Submit")),1)]),_:1})])])],40,Le)])])])]),n(Z,{onConfirm:C})])}}},Qe=I(Ue,[["__scopeId","data-v-309b20c8"]]);export{Qe as default};