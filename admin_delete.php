<?php

require "config.php"; // ملف الاتصال (يحتوي على متغير الاتصال $db)

header("Content-Type: application/json");

// استقبال البيانات القادمة كـ JSON من الـ Fetch API
$input = json_decode(file_get_contents("php://input"), true);
$action = isset($input['action']) ? $input['action'] : 'none';
$id     = isset($input['id']) ? intval($input['id']) : 0;

// التأكد من أن المعرّف صالح للاستخدام
if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "معرف العنصر غير صالح أو مفقود"]);
    exit;
}

// ============================================================
// تنفيذ إجراء: حذف عميل وحسابه (delete_customer)
// ============================================================
if ($action === 'delete_customer') {
    
    // 1. جلب الـ User_ID المرتبط بهذا العميل أولاً
    $stmt = $db->prepare("SELECT User_ID FROM customer WHERE Customer_ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $userId = $result['User_ID'] ?? null;
    $stmt->close();

    if (!$userId) {
        echo json_encode(["success" => false, "message" => "العميل غير موجود في النظام"]);
        exit;
    }

    // 2. إيقاف قيود المفاتيح الأجنبية مؤقتاً لحذف العميل والبيانات المتعلقة به
    $db->query("SET FOREIGN_KEY_CHECKS = 0");

    // بدء المعاملة الأمنية
    $db->begin_transaction();

    try {
        // حذف الحجوزات والتقييمات التابعة للعميل
        $stmt1 = $db->prepare("DELETE FROM Booking WHERE Customer_ID = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        $stmt2 = $db->prepare("DELETE FROM Rating WHERE Customer_ID = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        // حذف العميل من جدول customer
        $stmt3 = $db->prepare("DELETE FROM customer WHERE Customer_ID = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $stmt3->close();

        // حذف الحساب من جدول Account
        $stmt4 = $db->prepare("DELETE FROM Account WHERE User_ID = ?");
        $stmt4->bind_param("i", $userId);
        $stmt4->execute();
        $stmt4->close();

        $db->commit();
        echo json_encode(["success" => true, "message" => "تم حذف العميل، حساباته، وحجوزاته بنجاح ✓"]);
    } catch (Exception $e) {
        $db->rollback();
        echo json_encode(["success" => false, "message" => "حدث خطأ أثناء الحذف: " . $e->getMessage()]);
    }

    // 3. إعادة تفعيل قيود المفاتيح الأجنبية لحماية قاعدة البيانات
    $db->query("SET FOREIGN_KEY_CHECKS = 1");
    exit;
}

// ============================================================
// تنفيذ إجراء: حذف مزود خدمة وحسابه (delete_provider)
// ============================================================
if ($action === 'delete_provider') {
    
    // 1. جلب الـ User_ID المرتبط بمزود الخدمة
    $stmt = $db->prepare("SELECT User_ID FROM Provider WHERE Provider_ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $userId = $result['User_ID'] ?? null;
    $stmt->close();

    if (!$userId) {
        echo json_encode(["success" => false, "message" => "مزود الخدمة غير موجود"]);
        exit;
    }

    $db->query("SET FOREIGN_KEY_CHECKS = 0");
    $db->begin_transaction();

    try {
        // حذف الخدمات المرتبطة بالمزود من جدول servicepro
        $stmt1 = $db->prepare("DELETE FROM servicepro WHERE Provider_ID = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        // حذف الحجوزات المرتبطة بالمزود
        $stmt2 = $db->prepare("DELETE FROM Booking WHERE Provider_ID = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        // حذف المزود من جدول Provider
        $stmt3 = $db->prepare("DELETE FROM Provider WHERE Provider_ID = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $stmt3->close();

        // حذف الحساب من جدول Account
        $stmt4 = $db->prepare("DELETE FROM Account WHERE User_ID = ?");
        $stmt4->bind_param("i", $userId);
        $stmt4->execute();
        $stmt4->close();

        $db->commit();
        echo json_encode(["success" => true, "message" => "تم حذف مزود الخدمة وجميع بياناته المرتبطة بنجاح ✓"]);
    } catch (Exception $e) {
        $db->rollback();
        echo json_encode(["success" => false, "message" => "فشل حذف المزود: " . $e->getMessage()]);
    }

    $db->query("SET FOREIGN_KEY_CHECKS = 1");
    exit;
}

// ============================================================
// تنفيذ إجراء: حذف صنف (delete_category)
// ============================================================
if ($action === 'delete_category') {
    
    $db->query("SET FOREIGN_KEY_CHECKS = 0");
    $db->begin_transaction();

    try {
        // 1. جلب كافة الخدمات التابعة لهذا الصنف لحذف ارتباطاتها أولاً
        $stmt = $db->prepare("SELECT Service_ID FROM service WHERE Category_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $services = $stmt->get_result();
        $stmt->close();

        while ($row = $services->fetch_assoc()) {
            $sId = $row['Service_ID'];
            // حذف ارتباطات الخدمات في الجداول الأخرى
            $db->query("DELETE FROM servicepro WHERE Service_ID = $sId");
            $db->query("DELETE FROM Booking WHERE Service_ID = $sId");
            $db->query("DELETE FROM Rating WHERE Service_ID = $sId");
        }

        // 2. حذف الخدمات التابعة للصنف
        $stmt2 = $db->prepare("DELETE FROM service WHERE Category_ID = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        // 3. حذف الصنف نفسه
        $stmt3 = $db->prepare("DELETE FROM Category WHERE Category_ID = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $stmt3->close();

        $db->commit();
        echo json_encode(["success" => true, "message" => "تم حذف الصنف وجميع الخدمات والارتباطات التابعة له بنجاح ✓"]);
    } catch (Exception $e) {
        $db->rollback();
        echo json_encode(["success" => false, "message" => "فشل حذف الصنف: " . $e->getMessage()]);
    }

    $db->query("SET FOREIGN_KEY_CHECKS = 1");
    exit;
}

// ============================================================
// تنفيذ إجراء: حذف خدمة محددة (delete_service)
// ============================================================
if ($action === 'delete_service') {
    
    $db->query("SET FOREIGN_KEY_CHECKS = 0");
    $db->begin_transaction();

    try {
        // حذف كافة الارتباطات التابعة لهذه الخدمة أولاً
        $db->query("DELETE FROM servicepro WHERE Service_ID = $id");
        $db->query("DELETE FROM Booking WHERE Service_ID = $id");
        $db->query("DELETE FROM Rating WHERE Service_ID = $id");

        // حذف الخدمة من جدول service
        $stmt = $db->prepare("DELETE FROM service WHERE Service_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $db->commit();
        echo json_encode(["success" => true, "message" => "تم حذف الخدمة وكل ارتباطاتها بنجاح ✓"]);
    } catch (Exception $e) {
        $db->rollback();
        echo json_encode(["success" => false, "message" => "فشل حذف الخدمة: " . $e->getMessage()]);
    }

    $db->query("SET FOREIGN_KEY_CHECKS = 1");
    exit;
}

// في حال تم إرسال إجراء غير مدعوم
echo json_encode(["success" => false, "message" => "إجراء غير صالح أو غير معرف"]);

$db->close();
?>