import{L as c,u,o as d,U as f,b as p,d as _,e,G as l,H as n,h as o,f as x,w as b}from"./app.35649df7.js";import{_ as v}from"./SubmitButton.vue_vue_type_script_setup_true_lang.f325b795.js";import{u as h}from"./useNotyf.f631be2c.js";const y={class:"content content-boxed"},g=["onSubmit"],w={class:"col"},U=e("label",{class:"form-label",for:"example-if-username"},"Foydalanuvchi nomi",-1),V={class:"col"},M=e("label",{class:"form-label",for:"example-if-firstname"},"Ismi",-1),B={class:"col"},F=e("label",{class:"form-label",for:"example-if-lastname"},"Familiyasi",-1),N={class:"col text-end"},q=c({__name:"Profile",setup(S){const s=u({username:"",first_name:"",last_name:""}),r=h();d(()=>{const i=f().props.value.auth.user;Object.assign(s,i)});const m=()=>{s.put(route("profile.update",s),{onSuccess:()=>{r.success("Ma'lumotlar muvoffaqiyatli yangilandi!")}})};return(i,t)=>(p(),_("div",y,[e("form",{onSubmit:b(m,["prevent"]),class:"row row-cols-1 w-50 gap-3"},[e("div",w,[U,l(e("input",{type:"text",class:"form-control",id:"example-if-username","onUpdate:modelValue":t[0]||(t[0]=a=>o(s).username=a)},null,512),[[n,o(s).username]])]),e("div",V,[M,l(e("input",{type:"text",class:"form-control",id:"example-if-firstname","onUpdate:modelValue":t[1]||(t[1]=a=>o(s).first_name=a)},null,512),[[n,o(s).first_name]])]),e("div",B,[F,l(e("input",{type:"text",class:"form-control",id:"example-if-lastname","onUpdate:modelValue":t[2]||(t[2]=a=>o(s).last_name=a)},null,512),[[n,o(s).last_name]])]),e("div",N,[x(v,{loading:o(s).processing},null,8,["loading"])])],40,g)]))}});export{q as default};