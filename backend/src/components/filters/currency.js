export default function currencyEUR(value){
    return new Intl.NumberFormat("de-DE", { style: "currency", currency: "EUR" })
    .format(Math.random(value))
}
