import $ from 'jquery';

$(function () {
  console.log("✅ Inline GST verification block active");

  const gstBlock = $("#gstVerificationBlock");
  const gstInput = $("#gst_input");
  const errorEl = $("#gst_error");
  const verifyBtn = $("#verifyGstBtn");
  const manualBtn = $("#manualEntryBtn");
  const registrationForm = $("#registrationForm");

  // Show only GST block initially
  registrationForm.hide();

  // Manual Entry — user bypasses GST verification
  manualBtn.on("click", function () {
    gstBlock.hide();
    registrationForm.fadeIn();
  });

  // GST Verify
  verifyBtn.on("click", function () {
    const gst = gstInput.val().trim().toUpperCase();
    errorEl.hide();

    if (gst.length !== 15) {
      errorEl.text("Please enter a valid 15-character GST number.").show();
      return;
    }

    verifyBtn.prop("disabled", true).text("Verifying...");

    $.ajax({
      url: "/verify-gst",
      method: "POST",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
      data: { gst },
      success: function (res) {
        console.log("✅ GST API raw response:", res);

        if (!res.success || !res.data) {
          errorEl.text("Invalid response from GST server.").show();
          verifyBtn.prop("disabled", false).text("Verify GST");
          return;
        }

        const data = res.data;

        // ✅ Hide GST section and show registration form
        gstBlock.hide();
        registrationForm.fadeIn();

        // ✅ Auto-fill verified fields
        $("input[name='company_gst']").val(data.gst || gst).prop("readonly", true);
        $("input[name='industry_name']").val(data.name || "");
        $("input[name='pan_no']").val(data.pan || "");
        $("input[name='company_address']").val(data.address || "");

        // ✅ Make key fields read-only (if needed)
        $("input[name='industry_name']").prop("readonly", true);
        $("input[name='pan_no']").prop("readonly", true);
         $("input[name='company_address']").prop("readonly", true);

        console.log("✅ Auto-filled fields:", data);
        alert("✅ GST Verified Successfully");
      },
      error: function (xhr) {
        const msg = xhr.responseJSON?.message || "Verification failed. Please check your GST.";
        errorEl.text(msg).show();
      },
      complete: function () {
        verifyBtn.prop("disabled", false).text("Verify GST");
      },
    });
  });
});
