import{r as u,o as s,b as n,c as r,v as m}from"./app.56cb7126.js";const f=["value"],c={__name:"Input",props:{modelValue:"",small:{type:Boolean,default:!1}},emits:["update:modelValue"],setup(l){const e=u(null);return s(()=>{e.value.hasAttribute("autofocus")&&e.value.focus()}),(a,t)=>(n(),r("input",{class:m(["form-control",l.small&&"form-control-sm"]),value:l.modelValue,onInput:t[0]||(t[0]=o=>a.$emit("update:modelValue",o.target.value)),ref_key:"input",ref:e},null,42,f))}};export{c as _};
