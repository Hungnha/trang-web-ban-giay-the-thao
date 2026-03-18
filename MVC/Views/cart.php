<?php
$cartItems = $data['cartItems'] ?? [];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Giày Hiện Đại</title>
    <style>
        .main-content {
            background-color: #f9fafb;
            padding-top: 3rem;
            padding-bottom: 5rem;
            min-height: 80vh;
            font-family: 'Inter', sans-serif;
        }

        .cart-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 15px;
        }

        h1.cart-title {
            font-size: 2.2rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 2.5rem;
            color: #111827;
        }

        .cart-box {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .cart-list {
            padding: 0;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 24px;
            border-bottom: 1px solid #f3f4f6;
            gap: 20px;
            transition: background-color 0.2s;
        }

        .cart-item:hover {
            background-color: #fcfcfc;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #dc2626;
        }

        .item-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid #eee;
            background-color: #fff;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
            display: block;
            margin-bottom: 6px;
        }

        .item-meta {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .qty-control {
            display: flex;
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
            background-color: white;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: white;
            cursor: pointer;
            font-size: 1.2rem;
            color: #4b5563;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .qty-btn:hover {
            background-color: #f3f4f6;
            color: #dc2626;
        }

        .qty-input {
            width: 40px;
            text-align: center;
            border: none;
            border-left: 1px solid #f3f4f6;
            border-right: 1px solid #f3f4f6;
            font-weight: 600;
            font-size: 0.95rem;
            outline: none;
            color: #111827;
        }

        .item-price {
            font-size: 1.15rem;
            font-weight: 700;
            color: #dc2626;
            min-width: 120px;
            text-align: right;
        }

        .btn-remove {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #9ca3af;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-remove:hover {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .cart-actions {
            padding: 24px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 20px;
        }

        .summary-box {
            flex: 1;
            min-width: 300px;
            max-width: 400px;
            text-align: right;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1rem;
            color: #4b5563;
        }

        .summary-row.total {
            font-size: 1.3rem;
            font-weight: 800;
            color: #111827;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #d1d5db;
        }

        .summary-row.total .price {
            color: #dc2626;
        }

        .btn-checkout {
            background-color: #dc2626;
            color: white;
            padding: 12px 36px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
        }

        .btn-checkout:hover {
            background-color: #b91c1c;
            transform: translateY(-1px);
        }

        .btn-checkout.disabled {
            background-color: #d1d5db;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-wrap: wrap;
            }

            .cart-actions {
                flex-direction: column;
            }

            .summary-box {
                text-align: left;
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include_once "layout_header.php"; ?>

    <main class="main-content flex-grow-1">
        <div class="cart-container">
            <h1 class="cart-title">Giỏ Hàng Của Bạn</h1>

            <?php if (empty($cartItems)): ?>
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" alt="Empty Cart"
                        style="width: 120px; opacity: 0.5; margin-bottom: 20px;">
                    <p style="font-size: 1.2rem; color: #6b7280;">Giỏ hàng đang trống</p>
                    <a href="index.php?ctrl=product&act=list" class="btn-checkout"
                        style="display: inline-block; width: auto; margin-top: 10px; text-decoration:none;">Mua sắm ngay</a>
                </div>
            <?php else: ?>

                <form id="cart-form" action="index.php?ctrl=order&act=checkout" method="POST">

                    <div class="cart-box">
                        <div
                            style="padding: 16px 24px; background: #fff; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 15px;">
                            <input type="checkbox" id="check-all" class="custom-checkbox">
                            <label for="check-all" style="cursor: pointer; font-weight: 600; user-select: none;">Chọn tất cả
                                sản phẩm</label>
                        </div>

                        <div class="cart-list" id="cart-list">
                            <?php foreach ($cartItems as $item):
                                $cartKey = $item['key']; ?>
                                <div class="cart-item" data-key="<?= $cartKey ?>" data-price="<?= $item['price'] ?>">
                                    <input type="checkbox" name="selected_items[]" value="<?= $cartKey ?>"
                                        class="custom-checkbox item-check">
                                    <img src="Public/images/<?= htmlspecialchars($item['image_url']) ?>" class="item-img"
                                        onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                    <div class="item-info">
                                        <a href="#" class="item-name"><?= htmlspecialchars($item['name']) ?></a>
                                        <div class="item-meta">Phân loại: Size <?= $item['size'] ?></div>
                                        <div class="item-meta">Đơn giá: <?= number_format($item['price'], 0, ',', '.') ?>đ</div>
                                    </div>
                                    <div class="qty-control">
                                        <button type="button" class="qty-btn btn-dec">-</button>
                                        <input type="text" class="qty-input" value="<?= $item['quantity'] ?>" readonly>
                                        <button type="button" class="qty-btn btn-inc">+</button>
                                    </div>
                                    <div class="item-price" id="price-<?= $cartKey ?>">
                                        <?= $item['itemTotalFormatted'] ?>
                                    </div>
                                    <button type="button" class="btn-remove" title="Xóa sản phẩm">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="cart-actions">
                            <div class="summary-box">
                                <div class="summary-row">
                                    <span>Tạm tính (<span id="count-selected">0</span> sản phẩm):</span>
                                    <span id="sub-total">0 ₫</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Tổng thanh toán:</span>
                                    <span class="price" id="final-total">0 ₫</span>
                                </div>
                                <div style="margin-top: 20px;">
                                    <button type="submit" class="btn-checkout disabled" id="btn-pay">MUA HÀNG</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <?php include_once "layout_footer.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkAll = document.getElementById('check-all');
            const subTotalEl = document.getElementById('sub-total');
            const finalTotalEl = document.getElementById('final-total');
            const countSelectedEl = document.getElementById('count-selected');
            const btnPay = document.getElementById('btn-pay');

            const calculateTotal = () => {
                let subTotal = 0;
                let count = 0;

                document.querySelectorAll('.item-check').forEach(checkbox => {
                    if (checkbox.checked) {
                        const row = checkbox.closest('.cart-item');
                        const price = parseFloat(row.dataset.price);
                        const qty = parseInt(row.querySelector('.qty-input').value);
                        subTotal += price * qty;
                        count++;
                    }
                });

                subTotalEl.textContent = new Intl.NumberFormat('vi-VN').format(subTotal) + ' ₫';
                countSelectedEl.textContent = count;
                finalTotalEl.textContent = new Intl.NumberFormat('vi-VN').format(subTotal) + ' ₫';

                if (count > 0) btnPay.classList.remove('disabled');
                else btnPay.classList.add('disabled');
            };

            if (checkAll) {
                checkAll.addEventListener('change', () => {
                    document.querySelectorAll('.item-check').forEach(cb => cb.checked = checkAll.checked);
                    calculateTotal();
                });
            }

            document.getElementById('cart-list')?.addEventListener('change', (e) => {
                if (e.target.classList.contains('item-check')) {
                    const allChecks = document.querySelectorAll('.item-check');
                    const allChecked = document.querySelectorAll('.item-check:checked');
                    if (checkAll) checkAll.checked = (allChecks.length === allChecked.length);
                    calculateTotal();
                }
            });

            const sendUpdate = (key, qty, row) => {
                const formData = new FormData();
                formData.append('cart_key', key);
                formData.append('quantity', qty);

                fetch('index.php?ctrl=cart&act=update', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            row.querySelector('#price-' + key).textContent = data.itemTotalFormatted;
                            calculateTotal();
                        }
                    });
            };

            document.getElementById('cart-list')?.addEventListener('click', (e) => {
                const target = e.target;
                const row = target.closest('.cart-item');
                if (!row) return;

                const key = row.dataset.key;
                const input = row.querySelector('.qty-input');
                let qty = parseInt(input.value);

                if (target.closest('.btn-inc')) {
                    qty++;
                    input.value = qty;
                    sendUpdate(key, qty, row);
                }
                else if (target.closest('.btn-dec')) {
                    if (qty > 1) {
                        qty--;
                        input.value = qty;
                        sendUpdate(key, qty, row);
                    }
                }
                else if (target.closest('.btn-remove')) {
                    if (confirm('Xóa sản phẩm này khỏi giỏ hàng?')) {
                        const formData = new FormData();
                        formData.append('cart_key', key);
                        fetch('index.php?ctrl=cart&act=remove', { method: 'POST', body: formData })
                            .then(res => res.json())
                            .then(data => {
                                row.remove();
                                calculateTotal();
                                if (document.querySelectorAll('.cart-item').length === 0) location.reload();
                            });
                    }
                }
            });
        });
    </script>
</body>

</html>