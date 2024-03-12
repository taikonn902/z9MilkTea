document.addEventListener('DOMContentLoaded', function () {
    var cartItems = [];

    document.getElementById('lenght-cart').textContent = '0';

    if (document.getElementById('lenght-cart').textContent === '0') {
        var cart = document.getElementById('my-cart');
        cart.innerHTML = '<p class="title-none-cart">Giỏ hàng trống !!!</p>';
    }

    var storedCartItems = JSON.parse(localStorage.getItem('cartItems'));
    if (storedCartItems) {
        cartItems = storedCartItems;
        renderCart();
        updateCartTotal();
        updateCartLength();
    }

    function updateLocalStorage() {
        try {
            if (typeof Storage !== "undefined") {
                if (cartItems && cartItems.length > 0) {
                    localStorage.setItem('cartItems', JSON.stringify(cartItems));
                } else {
                    localStorage.removeItem('cartItems');
                }
            } else {
                console.error("Trình duyệt không hỗ trợ localStorage.");
            }
        } catch (error) {
            console.error("Lỗi khi lưu vào localStorage: " + error.message);
        }
    }

    // kiểm tra size đưuợc chọn và lưu vào selectedSize

    var sizeSelects = document.querySelectorAll('.size-select');
    var selectedSize = null;

    sizeSelects.forEach(function (sizeSelect) {
        var sizeOptions = sizeSelect.querySelectorAll('.size-option');

        sizeOptions.forEach(function (option) {
            option.addEventListener('click', function () {
                selectedSize = this.textContent;
                addToCart(selectedSize, this.closest('.product-item'));
                hideSizeSelects();
                updateCartLength();
            });
        });
    });

    // lấy các giá trị khi nhấn thêm giỏ hàng và gửi tới renderCart

    var addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var productItem = button.closest('.product-item');
            var sizeSelect = productItem.querySelector('.size-select');

            if (sizeSelectVisible(sizeSelect)) {
                hideSizeSelect(sizeSelect);
            } else {
                hideSizeSelects();
                showSizeSelect(sizeSelect);
            }
        });
    });

    function sizeSelectVisible(sizeSelect) {
        return !sizeSelect.classList.contains('hidden');
    }

    function addToCart(selectedSize, productItem) {
        if (!selectedSize) {
            alert('Vui lòng chọn kích thước trước khi thêm vào giỏ hàng.');
        } else {
            var productName = productItem.querySelector('.product-name').textContent;
            var productPriceElement = productItem.querySelector('.product-price');
    
            var productPriceString = productPriceElement.textContent.trim();
   
            var hyphenIndex = productPriceString.indexOf('-');
    
            var priceM = '';
            var priceL = '';
    
            if (hyphenIndex !== -1) {
                priceM = productPriceString.substring(0, hyphenIndex).trim();
                priceL = productPriceString.substring(hyphenIndex + 1).trim();
            } else {
                if (selectedSize === 'M') {
                    priceM = productPriceString.trim();
                } else if (selectedSize === 'L') {
                    priceL = productPriceString.trim();
                }
            }
    
            // console.log('productName:', productName);
            // console.log('productPriceString:', productPriceString);
            // console.log('hyphenIndex:', hyphenIndex);
            // console.log('priceM:', priceM);
            // console.log('priceL:', priceL);
            // console.log('selectedSize:', selectedSize);
    
            var productPrice = '';
    
            if (selectedSize === 'M' && priceM !== '') {
                productPrice = priceM;
            } else if (selectedSize === 'L' && priceL !== '') {
                productPrice = priceL;
            } else {
                productPrice = formatPrice(productPriceElement.getAttribute('data-price'));
            }
    
            // console.log('Final Product Price:', productPrice);
    
            var existingItem = cartItems.find(item => item.name === productName && item.size === selectedSize);
    
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                var cartItem = {
                    size: selectedSize,
                    image: productItem.querySelector('.product-img').src,
                    name: productName,
                    price: productPrice,
                    quantity: 1
                };
                cartItems.push(cartItem);
            }
    
            updateLocalStorage();
            updateCartTotal();
            renderCart();
            showSuccessOverlay();
        }
    }

    function updateCartTotal() {
        var cartTotalElement = document.querySelector('#cart-total span');
        var totalAmount = calculateTotalAmount();
        cartTotalElement.textContent = totalAmount;
    }

    function formatPrice(price) {
        var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            minimumFractionDigits: 3,
            maximumFractionDigits: 3
        });
    
        var formattedPrice = formatter.format(price);
        return formattedPrice.replace(/,/g, '.').replace(/\s/g, '');
    }
    
    function calculateTotalAmount() {
        var totalAmount = 0;
        cartItems.forEach(function (item) {
            var itemPrice = parseFloat(item.price);
            var itemQuantity = parseInt(item.quantity);
    
            if (!isNaN(itemPrice) && !isNaN(itemQuantity)) {
                totalAmount += itemPrice * itemQuantity;
            }
        });
        return formatPrice(totalAmount);
    }
    
    function renderCart() {
        var cart = document.querySelector('#my-cart');
        cart.innerHTML = '';
    
        if (cartItems.length === 0) {
            cart.innerHTML = '<p class="title-none-cart">Giỏ hàng trống !!!</p>';
            document.getElementById('lenght-cart').textContent = '0';
        } else {
            cartItems.forEach(function (item, index) {
                var cartItemElement = document.createElement('div');
                cartItemElement.classList.add('cart-item');
    
                var itemHTML = `
                    <div class="container-cart-item">
                        <div class="cart-product-img">
                            <img src="${item.image}" alt="product-img">
                        </div>
                        <div class="product-info">
                            <p class="cart-product-name" name="product_name">${item.name}</p>
    
                            <div class="grid-info">
                                <div class="info-left">
                                    <p class="cart-product-size" name="size_name">Kích thước: ${item.size}</p>
                                    <p class="cart-product-price" name="product_price">Giá: ${item.price}</p>
                                    <div class="quantity-controls">
                                        <button class="quantity-decrement" data-index="${index}">-</button>
                                        <input class="quantity-input" type="number" class="quantity-input" data-index="${index}" value="${item.quantity}" min="1">
                                        <button class="quantity-increment" data-index="${index}">+</button>
                                    </div>
                                </div>
    
                                <div class="info-right">
                                    <button class="delete-cart" data-index="${index}"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
    
                cartItemElement.innerHTML = itemHTML;
                cart.appendChild(cartItemElement);
            });
    
            updateCartLength();
    
            var deleteButtons = document.querySelectorAll('.delete-cart');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var index = button.getAttribute('data-index');
                    deleteCartItem(index);
                });
            });
    
            var quantityInputs = document.querySelectorAll('.cart-item .quantity-input');
            quantityInputs.forEach(function (input) {
                input.addEventListener('change', function () {
                    var index = input.getAttribute('data-index');
                    var newQuantity = parseInt(input.value);
    
                    if (isNaN(newQuantity) || newQuantity < 1) {
                        deleteCartItem(index);
                    } else {
                        cartItems[index].quantity = newQuantity;
                        updateCartTotal();
                        updateLocalStorage();
                        renderCart();
                    }
                });
            });
    
            var incrementButtons = document.querySelectorAll('.quantity-increment');
            incrementButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var index = button.getAttribute('data-index');
                    cartItems[index].quantity++;
                    updateCartTotal();
                    updateLocalStorage();
                    renderCart();
                });
            });
    
            var decrementButtons = document.querySelectorAll('.quantity-decrement');
            decrementButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var index = button.getAttribute('data-index');
                    if (cartItems[index].quantity > 1) {
                        cartItems[index].quantity--;
                        updateCartTotal();
                        updateLocalStorage();
                        renderCart();
                    } else {
                        deleteCartItem(index);
                    }
                });
            });
        }
    }    

    function updateCartLength() {
        var cartLengthElement = document.getElementById('lenght-cart');
        var count = cartItems.reduce((total, item) => total + item.quantity, 0);
        cartLengthElement.textContent = count.toString();
    }

    function showSuccessOverlay() {
        var containerSuccess = document.querySelector('.container-success');

        if (containerSuccess && containerSuccess.classList.contains('hidden')) {
            var successOverlay = containerSuccess.querySelector('#success-overlay');

            if (successOverlay) {
                containerSuccess.classList.remove('hidden');
                setTimeout(function () {
                    successOverlay.classList.add('slide-out-up');
                }, 1);

                setTimeout(function () {
                    containerSuccess.classList.add('hidden');
                    successOverlay.classList.remove('slide-out-up');
                }, 2000);
            }
        }
    }

    function deleteCartItem(index) {
        var isConfirmed = window.confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');
        if (isConfirmed) {
            cartItems.splice(index, 1);
            renderCart();
            updateCartTotal();
            updateCartLength();
            updateLocalStorage();
            showDeleteSuccessOverlay();
        }
    }

    function showDeleteSuccessOverlay() {
        var containerDeleteSuccess = document.getElementById('delete-success');

        if (containerDeleteSuccess && containerDeleteSuccess.classList.contains('hidden')) {
            var successOverlayDelete = containerDeleteSuccess.querySelector('#success-overlay-delete');

            if (successOverlayDelete) {
                containerDeleteSuccess.classList.remove('hidden');
                successOverlayDelete.classList.add('slide-out-up');

                setTimeout(function () {
                    containerDeleteSuccess.classList.add('hidden');
                    successOverlayDelete.classList.remove('slide-out-up');
                }, 2000);
            }
        }
    }

    function hideSizeSelects() {
        sizeSelects.forEach(function (sizeSelect) {
            hideSizeSelect(sizeSelect);
        });
    }

    function hideSizeSelect(sizeSelect) {
        sizeSelect.classList.add('hidden');
    }

    function showSizeSelect(sizeSelect) {
        hideSizeSelects();
        sizeSelect.classList.remove('hidden');
    }

    var clearCartButton = document.querySelector('.clear-cart-btn');
    clearCartButton.addEventListener('click', function () {
        var isConfirmed = confirm('Bạn có chắc chắn muốn xoá tất cả sản phẩm trong giỏ hàng không?');

        if (isConfirmed) {
            cartItems = [];
            renderCart();
            updateCartTotal();
            updateCartLength();
            updateLocalStorage();
            showDeleteSuccessOverlay();
        }
    });
});