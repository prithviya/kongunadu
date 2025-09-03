/* Store the element in el */
let el = document.querySelector('.image-view')

const height = el.clientHeight
const width = el.clientWidth

el.addEventListener('mousemove', handleMove)

function handleMove(e) {
  const xVal = e.layerX
  const yVal = e.layerY
  const yRotation = -10 * ((xVal - width / 2) / width)
  const xRotation = 10 * ((yVal - height / 2) / height)
  const string = 'perspective(500px) rotateX(' + xRotation + 'deg) rotateY(' + yRotation + 'deg)'

  el.style.transform = string
}

el.addEventListener('mouseout', function () {
  el.style.transform = 'perspective(500px) rotateX(0) rotateY(0)'
})

el.addEventListener('mousedown', function () {
  el.style.transform = 'perspective(500px) rotateX(0) rotateY(0)'
})

el.addEventListener('mouseup', function () {
  el.style.transform = 'perspective(500px) rotateX(0) rotateY(0)'
})