import{u as n,b as l,j as d,g as t,f as a,i as o,X as c,e,l as f,q as p,w as u}from"./app.71aa8fad.js";import{_}from"./Button.2e4451b2.js";import{_ as w}from"./GuestLayout.bef4c5b6.js";import{_ as b}from"./Input.ae56bb4b.js";import{_ as g}from"./InputError.c741514e.js";import{_ as h}from"./InputLabel.d74ae869.js";const x=e("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),V=["onSubmit"],v={class:"flex justify-end mt-4"},q={__name:"ConfirmPassword",setup(y){const s=n({password:""}),i=()=>{s.post(route("password.confirm"),{onFinish:()=>s.reset()})};return(C,r)=>(l(),d(w,null,{default:t(()=>[a(o(c),{title:"Confirm Password"}),x,e("form",{onSubmit:u(i,["prevent"])},[e("div",null,[a(h,{for:"password",value:"Password"}),a(b,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:o(s).password,"onUpdate:modelValue":r[0]||(r[0]=m=>o(s).password=m),required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),a(g,{class:"mt-2",message:o(s).errors.password},null,8,["message"])]),e("div",v,[a(_,{class:p(["ml-4",{"opacity-25":o(s).processing}]),disabled:o(s).processing},{default:t(()=>[f(" Confirm ")]),_:1},8,["class","disabled"])])],40,V)]),_:1}))}};export{q as default};