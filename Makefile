info:
	@echo "Usage: make test|style|install"

# pass any target to composer
$(MAKECMDGOALS):
	composer $(MAKECMDGOALS)
