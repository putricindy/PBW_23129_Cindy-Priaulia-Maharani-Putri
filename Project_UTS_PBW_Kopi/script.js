// Produk
const products = [
  { name: "Espresso Classic", price: 18000, image: "es1.jpg" },
  { name: "V60 Manual Brew", price: 22000, image: "manual.jpeg" },
  { name: "Cafe Mocha Muse", price: 25000, image: "mocha.jpg" },
  { name: "Cold Brew Lemonade", price: 24000, image: "lemonade.jpg" },
  { name: "Hazelnut Latte", price: 26000, image: "h.jpg" },
  { name: "Caramel Macchiato", price: 27000, image: "cm.jpg" },
  { name: "Cappuccino", price: 23000, image: "cp.jpeg" },
  { name: "Affogato Ice Cream", price: 28000, image: "affogatto.jpeg" }
];

// Render produk
const productGrid = document.querySelector('.products-grid');
products.forEach((product, index) => {
  const card = document.createElement('div');
  card.className = 'product-card';
  card.innerHTML = `
    <img src="${product.image}" alt="${product.name}">
    <div class="product-content">
      <h4>${product.name}</h4>
      <p class="product-price">Rp ${product.price.toLocaleString()}</p>
      <button class="add-to-cart" data-index="${index}">Pesan Sekarang</button>
    </div>
  `;
  productGrid.appendChild(card);
});

// Keranjang
let cart = [];
const cartIcon = document.querySelector('.cart-icon');
const cartModal = document.querySelector('.cart-modal');
const closeCart = document.querySelector('.close-cart');
const overlay = document.querySelector('.overlay');
const cartItems = document.querySelector('.cart-items');
const totalPriceEl = document.querySelector('.total-price');
const cartCountEl = document.querySelector('.cart-count');

// Tambah ke keranjang
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('add-to-cart')) {
    const index = e.target.getAttribute('data-index');
    addToCart(products[index]);
  }
});

function addToCart(product) {
  const found = cart.find(item => item.name === product.name);
  if (found) {
    found.qty++;
  } else {
    cart.push({ ...product, qty: 1 });
  }
  updateCart();
}

function updateCart() {
  cartItems.innerHTML = '';
  let total = 0;
  let count = 0;
  cart.forEach(item => {
    const div = document.createElement('div');
    div.className = 'cart-item';
    div.innerHTML = `
      <p>${item.name} x${item.qty}</p>
      <p>Rp ${(item.price * item.qty).toLocaleString()}</p>
    `;
    cartItems.appendChild(div);
    total += item.price * item.qty;
    count += item.qty;
  });
  totalPriceEl.textContent = `Rp ${total.toLocaleString()}`;
  cartCountEl.textContent = count;
}

// Toggle modal
cartIcon.addEventListener('click', () => {
  cartModal.classList.add('active');
  overlay.classList.add('active');
});
closeCart.addEventListener('click', () => {
  cartModal.classList.remove('active');
  overlay.classList.remove('active');
});
overlay.addEventListener('click', () => {
  cartModal.classList.remove('active');
  overlay.classList.remove('active');
});

// Hero slider
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const nextBtn = document.querySelector('.next-slide');
const prevBtn = document.querySelector('.prev-slide');

function showSlide(index) {
  slides.forEach(slide => slide.classList.remove('active'));
  slides[index].classList.add('active');
}
function nextSlide() {
  slideIndex = (slideIndex + 1) % slides.length;
  showSlide(slideIndex);
}
function prevSlide() {
  slideIndex = (slideIndex - 1 + slides.length) % slides.length;
  showSlide(slideIndex);
}

nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);
setInterval(nextSlide, 5000);
