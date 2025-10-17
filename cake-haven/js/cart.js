// js/cart.js
(function() {
  function send(data, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = () => {
      try {
        callback(JSON.parse(xhr.responseText));
      } catch (e) {
        console.error(e, xhr.responseText);
        callback(null);
      }
    };
    xhr.send(
      Object.keys(data)
        .map((k) => encodeURIComponent(k) + "=" + encodeURIComponent(data[k]))
        .join("&")
    );
  }

  function updateCartCount() {
    send({ action: "count" }, function (resp) {
      if (resp && resp.count !== undefined) {
        const countEl = document.getElementById("cart-count");
        if (countEl) countEl.textContent = resp.count;
      }
    });
  }

  document.addEventListener("click", function (e) {
    // Add to cart
    if (e.target.matches(".add-to-cart")) {
      const btn = e.target;
      const id = btn.dataset.id;
      const name = btn.dataset.name;
      const price = btn.dataset.price;
      const qtyInput = document.getElementById("qty");
      const qty = qtyInput ? qtyInput.value : 1;

      send({ action: "add", id, name, price, qty }, function (resp) {
        if (resp && resp.cartCount !== undefined) {
          const countEl = document.getElementById("cart-count");
          if (countEl) countEl.textContent = resp.cartCount;
          alert(`${name} added to cart!`);
        }
      });
    }

    // Remove item
    if (e.target.matches(".remove-item")) {
      const id = e.target.dataset.id;
      send({ action: "update", id, qty: 0 }, () => location.reload());
    }

    // Clear cart
    if (e.target.id === "clear-cart") {
      if (confirm("Clear your cart?")) send({ action: "clear" }, () => location.reload());
    }
  });

  // Quantity change
  document.addEventListener("change", function (e) {
    if (e.target.matches(".qty-input")) {
      const id = e.target.dataset.id;
      const qty = e.target.value;
      send({ action: "update", id, qty }, () => location.reload());
    }
  });

  // Update cart count on load
  document.addEventListener("DOMContentLoaded", updateCartCount);
})();
