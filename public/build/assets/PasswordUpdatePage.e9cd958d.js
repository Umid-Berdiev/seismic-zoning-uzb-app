import{u as m,b as u,d as _,e as t,f as o,h as e,g as c,w,k as f}from"./app.35649df7.js";import{_ as n}from"./Input.6c8b1c5c.js";import{_ as d}from"./InputError.cb4920f2.js";import{_ as l}from"./InputLabel.2dd648e5.js";import{_ as g}from"./SubmitButton.vue_vue_type_script_setup_true_lang.f325b795.js";import{u as V}from"./useNotyf.f631be2c.js";const v={class:"content content-boxed"},h=["onSubmit"],y={class:"col"},x={class:"col"},b={class:"col"},k={class:"col text-end"},T={__name:"PasswordUpdatePage",setup(N){const i=V(),s=m({current_password:"",new_password:"",confirm_password:""}),p=()=>{s.post(route("update-password"),{onFinish:()=>{s.reset()},onSuccess:()=>{i.success("Parol muvoffaqiyatli yangilandi!")}})};return(U,a)=>(u(),_("div",v,[t("form",{onSubmit:w(p,["prevent"]),class:"row row-cols-1 w-50 gap-3"},[t("div",y,[o(l,{for:"current_password",value:"Hozirgi parol"}),o(n,{id:"current_password",type:"password",modelValue:e(s).current_password,"onUpdate:modelValue":a[0]||(a[0]=r=>e(s).current_password=r),autocomplete:"current_password",autofocus:""},null,8,["modelValue"]),o(d,{message:e(s).errors.current_password},null,8,["message"])]),t("div",x,[o(l,{for:"new_password",value:"Yangi parol"}),o(n,{id:"new_password",type:"password",modelValue:e(s).new_password,"onUpdate:modelValue":a[1]||(a[1]=r=>e(s).new_password=r)},null,8,["modelValue"]),o(d,{message:e(s).errors.new_password},null,8,["message"])]),t("div",b,[o(l,{for:"confirm_password",value:"Yangi parolni qayta kiritish"}),o(n,{id:"confirm_password",type:"password",modelValue:e(s).confirm_password,"onUpdate:modelValue":a[2]||(a[2]=r=>e(s).confirm_password=r)},null,8,["modelValue"]),o(d,{message:e(s).errors.confirm_password},null,8,["message"])]),t("div",k,[o(g,{loading:e(s).processing},{default:c(()=>[f(" Tasdiqlash ")]),_:1},8,["loading"])])],40,h)]))}};export{T as default};
