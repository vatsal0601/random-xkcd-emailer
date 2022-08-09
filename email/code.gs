function doPost(e) {
	var quota = MailApp.getRemainingDailyQuota();
	Logger.log(quota); //logs no. of mails we can send in a day

	if (quota <= 0)
		return ContentService.createTextOutput(
			JSON.stringify({ error: true, message: "Daily limit exceed" })
		).setMimeType(ContentService.MimeType.JSON);

	var template;
	switch (e.parameter.type) {
		case "token":
			template = HtmlService.createTemplateFromFile("token");
			template.token = e.parameter.token;
			break;
		case "comic":
			template = HtmlService.createTemplateFromFile("comic");
			template.title = e.parameter.title;
			template.url = e.parameter.url;
			template.alt = e.parameter.alt;
			template.unsubscribe = e.parameter.unsubscribe;
			break;
		default:
			break;
	}

	template.name = e.parameter.name;
	var body = template.evaluate().getContent();
	return MailApp.sendEmail({
		to: e.parameter.to,
		subject: e.parameter.subject,
		htmlBody: body,
		name: "Vatsal from Emaaail",
	});
}
