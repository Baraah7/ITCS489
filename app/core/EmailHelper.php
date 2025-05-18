<?php

class EmailHelper {
    public static function sendOrderConfirmation($orderDetails) {
        $to = $orderDetails[0]['email'];
        $subject = "Order Confirmation - Order #" . $orderDetails[0]['order_id'];
        
        // Calculate totals
        $subtotal = 0;
        foreach ($orderDetails as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shipping = $subtotal >= 25 ? 0 : 5.99;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;

        // Build email content
        $message = "
            <html>
            <head>
                <title>Order Confirmation</title>
            </head>
            <body>
                <h1>Thank you for your order!</h1>
                <p>Order #" . $orderDetails[0]['order_id'] . "</p>
                <p>Date: " . date('F j, Y', strtotime($orderDetails[0]['order_date'])) . "</p>

                <h2>Shipping Information:</h2>
                <p>
                " . htmlspecialchars($orderDetails[0]['first_name'] . ' ' . $orderDetails[0]['last_name']) . "<br>
                " . htmlspecialchars($orderDetails[0]['address']) . "<br>
                " . ($orderDetails[0]['apartment'] ? htmlspecialchars($orderDetails[0]['apartment']) . "<br>" : "") . "
                " . htmlspecialchars($orderDetails[0]['city'] . ', ' . $orderDetails[0]['postal_code']) . "<br>
                " . htmlspecialchars($orderDetails[0]['country']) . "
                </p>

                <h2>Order Details:</h2>
                <table border='1' cellpadding='5' style='border-collapse: collapse;'>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>";

        foreach ($orderDetails as $item) {
            $message .= "
                    <tr>
                        <td>" . htmlspecialchars($item['title']) . "</td>
                        <td>" . $item['quantity'] . "</td>
                        <td>$" . number_format($item['price'], 2) . "</td>
                        <td>$" . number_format($item['price'] * $item['quantity'], 2) . "</td>
                    </tr>";
        }

        $message .= "
                    <tr>
                        <td colspan='3' align='right'><strong>Subtotal:</strong></td>
                        <td>$" . number_format($subtotal, 2) . "</td>
                    </tr>
                    <tr>
                        <td colspan='3' align='right'><strong>Shipping:</strong></td>
                        <td>" . ($shipping > 0 ? '$' . number_format($shipping, 2) : 'Free') . "</td>
                    </tr>
                    <tr>
                        <td colspan='3' align='right'><strong>Tax:</strong></td>
                        <td>$" . number_format($tax, 2) . "</td>
                    </tr>
                    <tr>
                        <td colspan='3' align='right'><strong>Total:</strong></td>
                        <td>$" . number_format($total, 2) . "</td>
                    </tr>
                </table>

                <p>We will contact you with delivery details.</p>
            </body>
            </html>";

        // Headers for HTML email
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: BookStore <noreply@bookstore.com>\r\n";

        // Send email
        return mail($to, $subject, $message, $headers);
    }
}
