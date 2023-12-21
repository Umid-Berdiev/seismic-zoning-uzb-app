import{_ as B,r as h,a as M,u as z,o as R,M as S,b as d,c as u,e as o,w,g as e,t as n,j as O,i as t,q as F,C as U,$ as T,F as C,h as I,a0 as Y,f as D,z as P,A as G,B as H}from"./app.56cb7126.js";import{b as J,w as K}from"./vue-dataset.es.b193e4bb.js";import{u as Q}from"./useNotyf.9adfdd7d.js";import{_ as b}from"./Input.7aced2d7.js";import"./moment.62d3fb0a.js";import{_ as W}from"./BaseBlock.22552c46.js";import{_ as f}from"./InputLabel.5b59311f.js";import{C as X}from"./ConfirmModal.5c5d956d.js";import{_ as y}from"./InputError.fee64527.js";import{_ as Z}from"./SubmitButton.vue_vue_type_script_setup_true_lang.371fd828.js";const p=c=>(G("data-v-0bb6b0fc"),c=c(),H(),c),ee={class:"content"},se=p(()=>e("div",{class:"d-flex justify-content-end"},[e("button",{type:"button",class:"btn btn-alt-primary push","data-bs-toggle":"modal","data-bs-target":"#userFormModal"},[e("i",{class:"si si-plus me-1"}),e("span",null,"Yangi foydalanuvchi qo'shish")])],-1)),ae={key:0,class:"text-center"},te={class:"row"},le={class:"col-md-12"},oe={class:"table-responsive"},ie={class:"table table-striped mb-0"},ne=p(()=>e("th",{scope:"col"},"#",-1)),de={scope:"row"},re={class:"d-flex gap-2"},ue=["onClick"],ce=p(()=>e("i",{class:"si si-pencil"},null,-1)),me=[ce],_e={class:"modal fade",id:"userFormModal",tabindex:"-1","aria-labelledby":"userFormModalLabel","aria-hidden":"true"},fe={class:"modal-dialog"},pe={class:"modal-content"},ve={class:"modal-header"},he={class:"modal-title",id:"userFormModalLabel"},be=p(()=>e("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"},null,-1)),ye={class:"modal-body"},ge=["onSubmit"],ke={class:"row"},we={class:"col-12 mb-3"},Fe={class:"col-12 mb-3"},Ve={class:"col-12 mb-3"},xe={key:0,class:"col-12 mb-3"},Me={class:"col-12 mb-3"},Se=["disabled"],Ue=p(()=>e("option",{selected:"",hidden:"",value:null}," Rol tanlang ",-1)),Ce=["value"],Ie={key:1,class:"col-12 mb-3"},Le={class:"input-group"},qe={key:0,class:"far fa-eye"},Ee={key:1,class:"far fa-eye-slash"},$e={class:"col-12 mb-3"},Ae={class:"form-check form-switch"},je=p(()=>e("label",{class:"form-check-label",for:"user_status"},"Faolmi?",-1)),Ne={class:"col-auto ms-auto"},Be={__name:"Users",props:{users:{type:Array,default:()=>[]},roles:{type:Array,default:()=>[]}},setup(c){const L=c,v=Q(),g=h(null),q=M([{name:"Ismi",field:"first_name"},{name:"Familiyasi",field:"last_name"},{name:"Foydalanuvchi nomi (Login)",field:"username"},{name:"Elektron manzili",field:"email"},{name:"Roli",field:"roles"},{name:"Faollik statusi",field:"is_active"}]),k=M({username:"",first_name:"",last_name:"",email:"",role_id:null,is_active:!0,password:"password123"}),s=z({username:"",first_name:"",last_name:"",email:"",role_id:null,is_active:!0,password:"password123"}),m=h(!1),V=h(!1),_=h("text"),E=h(null);R(()=>{g.value=new S("#userFormModal"),g.value._element.addEventListener("hidden.bs.modal",()=>{m.value=!1,s.reset()}),document.querySelectorAll("#datasetLength label").forEach(a=>{a.remove()});let i=document.querySelector("#datasetLength select");i&&(i.classList="",i.classList.add("form-select"))});async function $(){V.value=!0;try{m.value?s.put(route("users.update",k.id),{onSuccess:()=>{var i;v.success("Ma'lumotlar muvaffaqiyatli saqlandi!"),s.reset(),(i=g.value)==null||i.hide()}}):s.post(route("users.store"),{onSuccess:()=>{var i;v.success("Ma'lumotlar muvaffaqiyatli saqlandi!"),s.reset(),(i=g.value)==null||i.hide()}})}catch{v.error("Ma'lumotlarni saqlashda hatolik!")}finally{V.value=!1}}function A(i){m.value=!0;const a=L.users.find(l=>l.id===i);Object.assign(k,a),s.role_id=k.role_id=a.roles[0].id,s.first_name=a.first_name,s.last_name=a.last_name,s.username=a.username,s.email=a.email,s.is_active=a.is_active}function j(){const i=S.getInstance("#modal-confirm");roleForm.delete(route("users.destroy",k.id),{onSuccess:()=>{v.success("User successfully removed!")},onError:a=>{v.error("Error while deleting user!")}}),i.hide()}function N(){_.value==="password"?_.value="text":_.value="password"}return(i,a)=>(d(),u("div",ee,[se,o(W,{title:"Foydalanuvchilar jadvali","content-full":""},{default:w(()=>{var l;return[((l=c.users)==null?void 0:l.length)==0?(d(),u("div",ae,n(i.$t("No_data")),1)):(d(),D(t(K),{key:1,"ds-data":c.users},{default:w(()=>[e("div",te,[e("div",le,[e("div",oe,[e("table",ie,[e("thead",null,[e("tr",null,[ne,(d(!0),u(C,null,I(q,(r,x)=>(d(),u("th",{key:r.field},n(r.name),1))),128)),e("th",null,n(i.$t("Actions")),1)])]),o(t(J),{tag:"tbody",class:"fs-sm"},{default:w(({row:r,rowIndex:x})=>[e("tr",null,[e("th",de,n(x+1),1),e("td",null,n(r.first_name),1),e("td",null,n(r.last_name),1),e("td",null,n(r.username),1),e("td",null,n(r.email),1),e("td",null,n(r.roles[0].name),1),e("td",null,n(r.is_active?"Aktiv":"Aktiv emas"),1),e("td",re,[e("button",{type:"button",class:"btn btn-secondary w-auto","data-bs-toggle":"modal","data-bs-target":"#userFormModal",onClick:ze=>A(r.id)},me,8,ue)])])]),_:1})])])])])]),_:1},8,["ds-data"]))]}),_:1}),e("div",_e,[e("div",fe,[e("div",pe,[e("div",ve,[e("h5",he,n(m.value?"Foydalanuvchi ma'lumotlarini o'zgartirish":"Yangi foydalanuvchi ma'lumotlarini yaratish"),1),be]),e("div",ye,[e("form",{onSubmit:O($,["prevent"])},[e("div",ke,[e("div",we,[o(f,{value:"Foydalanuvchi nomi (login)",for:"username"}),o(b,{id:"username",type:"text",modelValue:t(s).username,"onUpdate:modelValue":a[0]||(a[0]=l=>t(s).username=l)},null,8,["modelValue"]),o(y,{message:t(s).errors.username},null,8,["message"])]),e("div",Fe,[o(f,{value:"Ismi",for:"first_name"}),o(b,{id:"first_name",type:"text",modelValue:t(s).first_name,"onUpdate:modelValue":a[1]||(a[1]=l=>t(s).first_name=l)},null,8,["modelValue"]),o(y,{message:t(s).errors.first_name},null,8,["message"])]),e("div",Ve,[o(f,{value:"Familiyasi",for:"last_name"}),o(b,{id:"last_name",type:"text",modelValue:t(s).last_name,"onUpdate:modelValue":a[2]||(a[2]=l=>t(s).last_name=l)},null,8,["modelValue"]),o(y,{message:t(s).errors.last_name},null,8,["message"])]),m.value?F("",!0):(d(),u("div",xe,[o(f,{value:"Elektron manzili",for:"email"}),o(b,{id:"email",type:"text",modelValue:t(s).email,"onUpdate:modelValue":a[3]||(a[3]=l=>t(s).email=l)},null,8,["modelValue"]),o(y,{message:t(s).errors.email},null,8,["message"])])),e("div",Me,[o(f,{value:"Roli",for:"user_role"}),U(e("select",{id:"user_role",class:"form-select","aria-label":"Role select",disabled:t(s).role_id===1,"onUpdate:modelValue":a[4]||(a[4]=l=>t(s).role_id=l)},[Ue,(d(!0),u(C,null,I(c.roles,l=>(d(),u("option",{value:l.id},n(l.name),9,Ce))),256))],8,Se),[[T,t(s).role_id]]),o(y,{message:t(s).errors.role_id},null,8,["message"])]),m.value?F("",!0):(d(),u("div",Ie,[o(f,{for:"pwd_input"},{default:w(()=>[P(" Yangi parol ")]),_:1}),e("div",Le,[o(b,{ref_key:"pwdInput",ref:E,type:_.value,class:"form-control",modelValue:t(s).password,"onUpdate:modelValue":a[5]||(a[5]=l=>t(s).password=l)},null,8,["type","modelValue"]),e("button",{type:"button",class:"input-group-text",onClick:N},[_.value==="password"?(d(),u("i",qe)):F("",!0),_.value==="text"?(d(),u("i",Ee)):F("",!0)])])])),e("div",$e,[e("div",Ae,[U(e("input",{"onUpdate:modelValue":a[6]||(a[6]=l=>t(s).is_active=l),class:"form-check-input",type:"checkbox",id:"user_status",checked:""},null,512),[[Y,t(s).is_active]]),je])]),e("div",Ne,[o(Z,{loading:t(s).processing},null,8,["loading"])])])],40,ge)])])])]),o(X,{onConfirm:j})]))}},Qe=B(Be,[["__scopeId","data-v-0bb6b0fc"]]);export{Qe as default};