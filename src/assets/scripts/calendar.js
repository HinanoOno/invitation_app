import {
  Input,
  Timepicker,
  initTE,
} from "tw-elements";

initTE({
  Input,
  Timepicker
});

const pickerInline = document.querySelector("#timepicker-inline-12");
const timepickerMaxMin = new Timepicker(pickerInline, {
  format12: true,
  inline: true,
});